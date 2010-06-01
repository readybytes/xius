<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class Jsfields extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = XiusHelpersUtils::isComponentExist('com_community',true) ? true : false;
		return $isExist;
	}
	
	
	/*return label + input box html */
	/*public function renderSearchableHtml()
	{
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$filter = array();
		$filter['id'] = $this->key;
		$field = jsfieldshelper::getJomsocialFields($filter);
		if(!$field)
			return parent::renderPluginSearchableHtml();
			
		$fieldHtml = jsfieldshelper::getFieldsHTML($field[0]);
		
		return $this->generateSearchHtml($field[0]->name,$fieldHtml);
	}*/
	
	
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$jsFields = jsfieldshelper::getJomsocialFields();
		
		if(empty($jsFields))
			return false;

		$pluginsInfo = array();
			
		foreach($jsFields as $f){
			if($f->type != 'group')
				$pluginsInfo[$f->id] = $f->name;
		}
		
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		$db = JFactory::getDBO();
		$columns = $this->getCacheColumns();
		if(!$columns)
			return false;

		$fType = Jsfieldshelper::getFieldType($this->key);
		if(!is_array($value)){
			if(is_array($columns)) {
				foreach($columns as $c){
					if(JString::strtolower($fType) == 'text' || $operator == XIUS_LIKE)
						$conditions =  $db->nameQuote($c['columnname']).' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
					else
						$conditions =  $db->nameQuote($c['columnname']).' '.$operator.' '.$db->Quote($this->formatValue($value));
					$query->where($conditions,$join);
					return true;
				}
			}
			else{
				if(JString::strtolwer($fType) == 'text' || $operator == XIUS_LIKE)
					$conditions =  $db->nameQuote($columns['columnname']).' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
				else
					$conditions =  $db->nameQuote($columns['columnname']).' '.$operator.' '.$db->Quote($this->formatValue($value));
					
				$query->where($conditions,$join);
				return true;
			}
			
			return false;
		}
		
		if(is_array($value)){
			
			if(is_array($columns)) {
				foreach($columns as $c){
					$conditions = '';
					$count = 0;
					foreach($value as $v){
						$conditions .= $count ? ' AND ' : ' ( ';
						$conditions .= ''.$db->nameQuote($c['columnname']).' LIKE '.$db->Quote('%'.$this->formatValue($v).'%');
						$count++;
						//$query->where($conditions);
					}
					
					$conditions .= ' ) ';
					//$query->select($c['columnname']);
					$query->where($conditions,$join);
				}
				
				return true;
				
			}
			else{
				//$query->select($columns['columnname']);
				$conditions = '';
				$count = 0;
				foreach($value as $v){
					$conditions .= $count ? ' AND ' : ' ( ';
					$conditions .=  $db->nameQuote($columns['columnname']).' LIKE '.$db->Quote('%'.$this->formatValue($v).'%');
					$count++;
					//$query->where($conditions,'OR');
				}
				$query->where($conditions,$join);
				return true;
			}
		}		
		return false;		
	}
	
	
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		$query->select(strtolower($this->pluginType).$this->key.'.value as '.strtolower($this->pluginType).$this->key);
		$query->leftJoin('`#__community_fields_values` as '.strtolower($this->pluginType).$this->key.' ON ( '.strtolower($this->pluginType).$this->key.'.`user_id` = juser.`id`'
				.' AND '.strtolower($this->pluginType).$this->key.'.`field_id` = '.$this->key.')');
	}
	
	function formatValue($value)
	{
		//print_r(var_export($value));
		//return $value;
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo))
			return $value;
		
		if($fieldInfo[0]->type == 'checkbox' || $fieldInfo[0]->type == 'list')
			return $value;


		if($fieldInfo[0]->type == 'date')
		{
			//$values = array();
			$splitValue = split('-',$value);
			if( count($splitValue) < 3)
				return $value;
			$value		= $splitValue;
		}

		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::formatData($value);		
		}
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		return $formatvalue;
	}
	
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo[0]->name;
			
		return false;
	}
	
	
	/*Function will format data in display form on mini profile	 */
	public function _getFormatData($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		/*XITODO : Cache jomsocial fields */
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo) || is_array($value)) {
			$formatvalue = implode(',',$value);
			return $formatvalue;
		}
		
		if($fieldInfo[0]->type == 'date'){
			$db 	= &JFactory::getDBO(); 
			$query	= 'SELECT DATE_FORMAT('.$db->Quote($value).', "%d-%m-%Y") AS FORMATED_DATE';
			$db->setQuery($query);
			return $db->loadResult();
		}		
		
		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::getFieldData($value);			
		}
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		$formatvalue = CProfileLibrary::getFieldData($fieldInfo[0]->type,$value);
		return $formatvalue;
	}
	
	
}
