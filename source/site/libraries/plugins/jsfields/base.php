<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';
require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'fieldtable.php';

class JsfieldsBase extends XiusBase
{

	static $queryRequired = true;
	
	function __construct()
	{		
		parent::__construct(get_class($this));
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = XiusHelperUtils::isComponentExist('com_community',true) ? true : false;
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
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		$db = JFactory::getDBO();
		$columns = $this->getTableMapping();
		if(!$columns)
			return false;
			
		if(!is_array($columns)) 
			return false;
			
		$fType = Jsfieldshelper::getFieldType($this->key);
		
		Jsfieldshelper::changeValueFormat($value, $fType);
		
		if(!is_array($value)){		
			foreach($columns as $c){
                //format the column before making the condition
				$formatedColumn = $this->formatColumn($c, $db); //call parent's function
				if(  JString::strtolower($fType) == 'text' ||
					 JString::strtolower($fType) == 'textarea' ||
					 JString::strtolower($fType) == 'checkbox' ||
					 $operator == XIUS_LIKE
					)
					$conditions =  $formatedColumn.' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
				else
					$conditions =  $formatedColumn.' '.$operator.' '.$db->Quote($this->formatValue($value));
				$query->where($conditions,$join);
			}
			return true;			
		}
		
		if(is_array($value)){			
				foreach($columns as $c){
					$conditions = '';
					$count = 0;
					foreach($value as $v){
						$conditions .= $count ? ' OR ' : ' ( ';
						$conditions .= ''.$db->quoteName($c->cacheColumnName).' LIKE '.$db->Quote('%'.$this->formatValue($v).'%');
						$count++;
						//$query->where($conditions);
					}
					
					$conditions .= ' ) ';
					//$query->select($c['columnname']);
					$query->where($conditions,$join);
				}
				
				return true;			
			}	
		return false;		
	}
	
    function validateValues($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		if($fieldInfo[0]->type == 'profiletypes' && $value == 0)
			return false;
		return parent::validateValues($value);	
	}
	/*
	 * return the information related to the source table  
	 */
	function getTableMapping()
	{
		
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);

		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= "`#__xius_jsfields_value`";//'`#__community_fields_values`';
		$object->tableAliasName 	= "jsfields_value";//strtolower($this->pluginType).$this->key.'_'.$count;
		$object->originColumnName	= "field_id_{$this->key}";//'value';
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec		= $this->getCacheSqlSpec($fieldInfo);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getUserData(XiusQuery &$query)
	{
		
		$tableMapping = $this->getTableMapping();
		foreach( $tableMapping as $tm)
			$query->select(" {$tm->tableAliasName}.{$tm->originColumnName} as {$tm->cacheColumnName} ");
			
		if(self::$queryRequired)
		{
          XiusJsfieldTable::_buildQuery();

		  $query->leftJoin("{$tableMapping[0]->tableName} AS {$tableMapping[0]->tableAliasName}
							ON 
							juser.`id` = {$tableMapping[0]->tableAliasName}.`user_id`");

		  self::setqueryRequired();
		}
		
//		$query->select('juser.`id` as userid');
//		$query->from('`#__users` as juser');
//		$tableMapping = $this->getTableMapping();
//		foreach( $tableMapping as $tm){
//			$query->select(" {$tm->tableAliasName}.{$tm->originColumnName} as {$tm->cacheColumnName} ");
//			$query->leftJoin(" {$tm->tableName} as {$tm->tableAliasName} ON "
//								." ( {$tm->tableAliasName}.`user_id` = juser.`id` "
//								." AND  {$tm->tableAliasName}.`field_id` = {$this->key} "
//								." ) "
//							);
//		}		
	}
	
	// set variable queryRequired
     public static function setqueryRequired($queryRequired=false)
      {
      	self::$queryRequired=$queryRequired;
      } 
      
	/* at the time of saving data into database durin search also */
	function formatValue($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo))
			return $value;
		
		if($fieldInfo[0]->type == 'checkbox' || $fieldInfo[0]->type == 'list')
			return $value;


		if($fieldInfo[0]->type == 'date' || $fieldInfo[0]->type == 'birthdate')
		{
			//$splitValue = split('-',$value);
			$splitValue = explode('-',$value);
			if( count($splitValue) < 3)
				return $value;
			$value		= $splitValue;
		}

		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::formatData($value);		
		}
		//if jsAutoComplete plugin is installed
		if($fieldInfo[0]->type == 'jsautocomplete'){
			$value = explode(',',$value);
		}

		if($fieldInfo[0]->type == 'url' ){
			$prefix    = JRequest::getVar('field'.$this->key,'http://');			
			$value1[0] = $prefix[0];
			$value1[1] = JString::str_ireplace($value1[0],'', $value);
			$value     = $value1;
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

		if(is_array($value) && $value!=array())
				$value = implode(",",$value);
		
		if(empty($fieldInfo))
			return $value;
			
		if($fieldInfo[0]->type == 'date' || $fieldInfo[0]->type == 'birthdate'){
			$db 	= JFactory::getDBO(); 
			$query	= 'SELECT DATE_FORMAT('.$db->Quote($value).', "%d-%m-%Y") AS FORMATED_DATE';
			$db->setQuery($query);
			$result= $db->loadResult();
			return ($result == "00-00-0000") ? '' : $result ;
		}		
		
		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::getFieldData($value);			
		}
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		//$formatvalue = CProfileLibrary::getFieldData($fieldInfo[0]->type,$value);
		// for JS 2.2.1 not tested with 2.2.0
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		//$formatvalue = CProfileLibrary::getFieldData($fieldInfo[0]);
		return $formatvalue;
	}
	
	public function _getFormatAppliedData($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo) && $fieldInfo[0]->type == 'birthdate'){
			Jsfieldshelper::changeValueFormat($value, $fieldInfo[0]->type);
			return $value;
		}
		
		if($fieldInfo != array() && $fieldInfo[0]->type == 'date')
			return $value;
		
		return $this->_getFormatData($value);
	}
	
	function getCacheSqlSpec($fieldInfo){
		$specification = 'varchar(250) NOT NULL';
		
		if(!empty($fieldInfo) && ($fieldInfo[0]->type === 'date'|| $fieldInfo[0]->type === 'birthdate'))
			$specification = "datetime NOT NULL";
			
		return $specification;	
	}	
	
}
