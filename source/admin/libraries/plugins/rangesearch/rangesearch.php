<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class Rangesearch extends XiusBase
{

	function __construct()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,JText::_("INVALID XML PARAMETER FILE"));
			return false;
		}	
		parent::__construct(__CLASS__);
	}
	

			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
	
		$allInfo = XiusLibrariesInfo::getAllInfo();
		
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
		$object->cacheSqlSpec		= ' INT (31) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getUserData(XiusQuery &$query)
	{
		$plgInstance = XiusFactory::getPluginInstanceFromId($this->key);
		if(!$plgInstance)
			return false;
			
		$tableMapping = $plgInstance->getTableMapping();
		$myTableMapping = $this->getTableMapping();
		$date=date('Y');
		
		foreach($myTableMapping as $mtm)
		{ 
			foreach($tableMapping as $tm)
			{
				$sql = " ( (";				
				if($this->pluginParams->get('rangesearchType','date') === 'date')
					$sql = " ( $date - YEAR( ";
					
				$query->select("{$sql}{$tm->tableAliasName}.{$tm->originColumnName}))"
								." as {$mtm->cacheColumnName}"
							   );				
			}
		}
		
	}
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = XiusLibrariesInfo::getInfo($filter);
		
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
		return JText::_('RANGESEARCH FROM')." $value[0] ".JText::_('RANGESEARCH TO')." $value[1]";	
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
			$conditions =  ' ( '.$db->nameQuote($c->cacheColumnName).' >= '.$db->Quote($value[0]).' AND '.$db->nameQuote($c->cacheColumnName).' <= '.$db->Quote($value[1]).' ) ';
			$query->where($conditions,$join);				
		}
		return true;
	}
	
	public function validateValues($value)
	{
		$value = $this->_getArrangedValue($value);
		if( is_numeric($value[0]) && is_numeric($value[1]) )
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
				$value[0]=0;

			if((array_key_exists(1,$value) && !($value[1])) || !array_key_exists(1,$value))
				$value[1]=0;
			
			sort($value);
			return $value;			
		}
		else{
			$val[0] = 0;
			$val[1] = $value;
			return $val;
		}		
	}		
	
	public function cleanPluginObject()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		
		if(!$this->pluginParams)
			$this->pluginParams	= new JParameter('','');	
	}
	
}
