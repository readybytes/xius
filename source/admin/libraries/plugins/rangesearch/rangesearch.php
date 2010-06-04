<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class Rangesearch extends XiusBase
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
		$object->cacheSqlSpec		= ' INT (5) NOT NULL DEFAULT 0 ';
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
			foreach($tableMapping as $tm)
				$query->select(" ( $date - YEAR({$tm->tableAlliasName}.{$tm->originColumnName}))"
								." as {$mtm->cacheColumnName}"
							   );
		
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
		if(is_array($value)){
			$value = $this->_getArrangedValue($value);
			return "From {$value[0]} to {$value[1]}";
		}
		return $value;
	}
	
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
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
			$conditions =  ' ( '.$db->nameQuote($c->cacheColumnName).' >= '.$db->Quote($value[0]).' AND '.$db->nameQuote($c['columnname']).' <= '.$db->Quote($value[1]).' ) ';
			$query->where($conditions,$join);				
		}
		return true;
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
}
