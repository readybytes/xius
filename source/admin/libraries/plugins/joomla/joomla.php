<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';

class Joomla extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$fields = Joomlahelper::getJoomlaFields();
		
		if(empty($fields))
			return false;

		$pluginsInfo = array();
			
		foreach($fields as $k => $v){
			if($k == 'params' || $k == 'password'
					|| $k == 'activation' || $k == 'sendEmail')
				continue;
				
			$pluginsInfo[$k] = JText::_($k);
		}
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		$db = JFactory::getDBO();
		if(!is_array($value)) {
			$columns = $this->getCacheColumns();
			if(!$columns)
				return false;
				
			if(is_array($columns)) {
				foreach($columns as $c){
					if($this->key == 'registerDate')
						$conditions = "DATE_FORMAT(".$db->nameQuote($c['columnname']).", '%d-%m-%Y')".$operator."'".$this->formatValue($value)."'";
					else
						$conditions =  $db->nameQuote($c['columnname'])." ".XIUS_LIKE." '%".$this->formatValue($value)."%'";
					
					$query->where($conditions,$join);
					return true;
				}
			}
			else{
				if($this->key == 'registerDate')
					$conditions = "DATE_FORMAT(".$db->nameQuote($c['columnname']).", '%d-%m-%Y')".$operator."'".$this->formatValue($value)."'";
				else{
					/*IMP : We are using directly LIKE operator here
					 * for text box , if we change any field presentation 
					 * we have to change this also
					 */
					$conditions =  $db->nameQuote($c['columnname'])." ".XIUS_LIKE." '%".$this->formatValue($value)."%'";
				}
					
				$query->where($conditions,$join);
				return true;
			}
			
			return false;
		}
		
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		
		$query->select('joomlauser'.$this->getCacheColumnName().'.'.$this->getCacheColumnName().' as '.strtolower($this->pluginType).$this->getCacheColumnName());
		
		$query->leftJoin('`#__users` as joomlauser'.$this->getCacheColumnName().' ON ( joomlauser'.$this->getCacheColumnName().'.`id` = juser.`id` )' );
	}
	
	
	function getInfoName()
	{
		//$filter = array();
		$filter = $this->key;
		$fieldInfo = Joomlahelper::getJoomlaFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo;
			
		return false;
	}
	
	
	public function getCacheColumns()
	{
		if($this->key == 'registerDate'){
			$details[] = array();
			$details[0]['columnname'] = strtolower($this->pluginType).$this->getCacheColumnName();
			$details[0]['specs'] = 'datetime NOT NULL';
			return $details; 
		}
		
		if($this->key == 'id'){
			$details[] = array();
			$details[0]['columnname'] = strtolower($this->pluginType).$this->getCacheColumnName();
			$details[0]['specs'] = 'int(21) NOT NULL';
			return $details;
		}
		
		return parent::getCacheColumns();
	}
	
	
	/*function formatValue($value)
	{
		if($this->key == 'registerDate')
		{
			//$values = array();
			$value = split('-',$value);
		}
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		return $formatvalue;
	}*/
	
	
	public function _getFormatData($value)
	{
		if($this->key != 'registerDate')
			return parent::_getFormatData($value);
		
		$value = split('-',$value);
		$finalvalue = '';
			
		if(is_array($value)){
			if( empty( $value[0] ) || empty( $value[1] ) || empty( $value[2] ) )
				$finalvalue = '';
			else {
				if(JString::strlen($value[0]) == 4){
					$year	= intval($value[0]);
					$month	= intval($value[1]);
					$day	= intval($value[2]);
				}
				else{
					$day	= intval($value[0]);
					$month	= intval($value[1]);
					$year	= intval($value[2]);
				}
				
				$day 	= !empty($day) 		? $day 		: 1;
				$month 	= !empty($month) 	? $month 	: 1;
				$year 	= !empty($year) 	? $year 	: 1970;
				
				$finalvalue	= $day . '-' . $month . '-' . $year;
			}
		}
			
		return $finalvalue;	
	}
}
