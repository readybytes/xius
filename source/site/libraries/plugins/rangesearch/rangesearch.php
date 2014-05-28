<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class Rangesearch extends XiusBase
{

	function __construct()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new XiusParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,XiusText::_("INVALID_XML_PARAMETER_FILE"));
			return false;
		}	
		return (parent::__construct(__CLASS__));
	}
	

			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
	
		$allInfo = XiusLibInfo::getAllInfo();
		
		if(empty($allInfo))
			return false;

		$pluginsInfo = array();
			
		foreach($allInfo as $info){
			if($info->pluginType != 'Rangesearch')
				$pluginsInfo[$info->id] = $info->labelName;
		}
		
		return $pluginsInfo;
	}

	/*
	function getCacheColumns()
	{
		$details[] = array();
		$details[0]['columnname'] = strtolower($this->pluginType).$this->getCacheColumnName();
		$details[0]['specs'] = 'int NOT NULL';
		//$details[0]['default'] = '';
		return $details;
	}
	*/
	
	/*
	 * return the information related to the source table  
	 */
	function getTableMapping()
	{
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '';
		$object->tableAliasName 	= '';
		$object->originColumnName	= '';
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec		= ' FLOAT (31) NOT NULL DEFAULT 0 ';
		if(JString::strtolower($this->pluginParams->get('rangesearchType','date')) === 'date-range')
			$object->cacheSqlSpec		= ' DATE NOT NULL ';			
		
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getUserData(XiusQuery &$query)
	{
		$plgInstance = XiusFactory::getPluginInstance('',$this->key);
		if(!$plgInstance)
			return false;
			
		$tableMapping = $plgInstance->getTableMapping();
		$myTableMapping = $this->getTableMapping();
		
		foreach($myTableMapping as $mtm)
		{ 
			foreach($tableMapping as $tm)
			{
			 	$columnName = "$tm->tableAliasName.$tm->originColumnName";
			 	
				$sql = " $columnName as {$mtm->cacheColumnName}";
								
				if($this->pluginParams->get('rangesearchType','date') === 'date')
                 {  //If birthday field is empty for some users then it assigns 0
					$sql = "(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS($columnName)),'%Y')+0) As $mtm->cacheColumnName";
				 }
				$query->select($sql);				
			}
		}
		
	}
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = XiusLibInfo::getInfo($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo[0]->labelName;
			
		return false;
	}
	
	/*Available for converting raw data into format data*/
	public function _getFormatData($value)
	{
		return $value;
	}
	
	public function _getFormatAppliedData($value)
	{
		$value = $this->_getArrangedValue($value);
		return XiusText::_('RANGESEARCH_FROM')." $value[0] ".XiusText::_('RANGESEARCH_TO')." $value[1]";	
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
		
		if(!$value)
			return false;

		// cerate the min date anf max date according to given values
		$value = $this->_getArrangedValue($value);

		if(!is_array($columns))
			return false;

		//apply search
		foreach($columns as $c){
             //format the column before making the condition
			$formatedColumn =  $this->formatColumn($c, $db); // call parent function 
			$conditions     =  $formatedColumn.' BETWEEN '
							   .$db->Quote($this->formatValue($value[0]))
							   .' AND '.$db->Quote($this->formatValue($value[1]));
			$query->where($conditions,$join);				
		}
		return true;
	}
	
	public function validateValues($value)
	{
		$value = $this->_getArrangedValue($value);
		if( is_numeric($value[0]) && is_numeric($value[1]) )
			return true;
			
		if( $this->_isDate($value[0]) && $this->_isDate($value[1]) )
				return true;
			

		return false;
	}
	
    // this function will return the arranged value given for searching according to range
    // will convert values in range
	function _getArrangedValue($value)
	{
		if(!$value)
			return false;
			
		if(is_array($value)){
			if((array_key_exists(0,$value) && !($value[0])) || !array_key_exists(0,$value))
				$value[0]= $this->pluginParams->get('rangesearchstart',0);

			if((array_key_exists(1,$value) && !($value[1])) || !array_key_exists(1,$value))
				$value[1] = $this->pluginParams->get('rangesearchend',100);
			
			sort($value);						
		}
		else{
			$temp = $value;
			$value=array();
			$value[0] = 0;
			$value[1] = $temp;			
		}
		return $value;
	}		
	
	public function cleanPluginObject()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new XiusParameter($data,$paramsxmlpath);
		
		if(!$this->pluginParams)
			$this->pluginParams	= new XiusParameter('','');	
	}
	
	public function _isDate($date)
	{
		  // check the format first (may not be necessary as we use checkdate() below)
		   if(!preg_match("^[0-9]{2}-[0-9]{2}-[0-9]{4}$^", $date))
		  		return FALSE;
		  else{
		      	 $arrDate = explode("-", $date);		// break up date by slash
		     	 $intDay = $arrDate[0];
		      	 $intMonth = $arrDate[1];
		      	 $intYear = $arrDate[2];
		      	 $intIsDate = checkdate($intMonth, $intDay, $intYear);
		      	  if(!$intIsDate)
		      	  	    return FALSE;
		   		}
		      return TRUE;
	}
	
	function formatValue($value)
	{
		if(JString::strtolower($this->pluginParams->get('rangesearchType','date')) === 'date-range'){
			jimport('joomla.utilities.date');
			$dateFrom 	= new JDate($value);
			return $dateFrom->toSql(); 
		}
		return $value;
	}
	
}
