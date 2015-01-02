<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

//XiTODO:: Change class name
class Customtable extends XiusBase
{
	static  $joomlaGroups = array();
	
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
	/*
	 * return All table name that exists in your Data-Base
	 */
	
	public function getAvailableInfo()
	{
		//give all available table
		$tables = JFactory::getDBO()->getTableList();	
		
		if(empty($tables))
			return false;

		$pluginsInfo = array();
			
		foreach($tables as $v)
			$pluginsInfo[$v] = $v;
		
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		//XITODO : Assert Here
//		if(is_array($value))
//			return false;

		//get all cache columns 
		$columns = $this->getTableMapping();
		
		if(!$columns)
			return false;

		$db = JFactory::getDBO();
		foreach($columns as $c){
            
            //format the column before making the condition
			$formatedColumn = $this->formatColumn($c, $db);
			$conditions     =  $formatedColumn.' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
			if(JString::stristr(JString::strtolower($c->cacheSqlSpec),'date'))
			  $conditions = $formatedColumn.' '.$operator.' '.$db->Quote($this->formatValue($value));
				
			$query->where($conditions,$join);
		}		
		return true;
	}
	
   //format the column according to the type of information
   function formatColumn($column , $db)
	{
		if(JString::stristr(JString::strtolower($column->cacheSqlSpec),'date'))
			return "DATE_FORMAT(".$db->quoteName($column->cacheColumnName).", '%d-%m-%Y') ";

		 return parent::formatColumn($column, $db);
	}

	/*
     * @since Xius-4.1	
	 */
	function formatValue($value)
	{
		$isMultiple = $this->pluginParams->get('customIsMultiple');
		
		if($isMultiple) {
			$value = strtok($value, ',');
			return ",$value,";
		}
		
		return $value;
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');

		$isMultiple = $this->pluginParams->get('customIsMultiple');

		$tableMapping = $this->getTableMapping();
		
		foreach( $tableMapping as $tm){
			if($isMultiple) {
				$query->select( "CONCAT( \",\" ,group_concat({$tm->tableAliasName}.{$tm->originColumnName}), \",\" )"
							." as {$tm->cacheColumnName} "
				);
			}
			else {
				$query->select( "{$tm->tableAliasName}.{$tm->originColumnName} as {$tm->cacheColumnName} " );
			}
			$query->leftJoin( " {$tm->tableName}  as {$tm->tableAliasName}   "
							 ." ON ( {$tm->tableAliasName}.`{$this->pluginParams->get('customUseridColumn')}` = juser.`id` ) "
							);
		}
	}
	
	function getTableMapping()
	{
		$tableInfo					= array();
		//$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= $this->key;
		$object->tableAliasName 	= $this->pluginType.$this->key.$this->pluginParams->get('customSearchColumn');//."_$count";
		$object->originColumnName	= $this->pluginParams->get('customSearchColumn');
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.$this->pluginParams->get('customSearchColumn');//.'_'.$count;
		$object->cacheSqlSpec 		= $this->getCacheSqlSpec($this->key);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getInfoName()
	{
		return $this->key;		
	}
	
	function getCacheSqlSpec($key)
	{
		$db 		= JFactory::getDBO();
		$table  	= XiusTable::replacePrefix($key);
		$column 	= $this->pluginParams->get('customSearchColumn');
		$isMultiple = $this->pluginParams->get('customIsMultiple');
		
		//if this key can has multiple value for a user than should select multiple
		//so make the field type to varchar
		if($isMultiple) {
			return "varchar(250) not null DEFAULT '0'";
		}
		
		static $specs = null;
		if(isset($specs[$table])){
			$type 	 = $specs[$table][$column]->Type;
			$null    = $specs[$table][$column]->Null == 'NO' ? 'NOT NULL' : '';
			$default = isset($specs[$table][$column]->Default) ? "DEFAULT '{$specs[$table][$column]->Default}'" : '';
			return $type.' '.$null.' '.$default;
		}
		
		$query = "SHOW COLUMNS FROM ".$db->quoteName($table);
		$db->setQuery($query);
		$specs[$table] = $db->loadObjectList('Field');
		
		// assert if column spec not found
		assert(!empty($specs[$table]));
		
		$type 	 = $specs[$table][$column]->Type;
		$null    = $specs[$table][$column]->Null == 'NO' ? 'NOT NULL' : '';
		$default = isset($specs[$table][$column]->Default) ? "DEFAULT '{$specs[$table][$column]->Default}'" : '';
		return $type.' '.$null.' '.$default;		
	}
	
	/* formatting displaying output */
//	public function _getFormatData($value)
//	{
//			
//		
//		// format values for other type , remove the other
//		$mapping = array_shift($this->getTableMapping());
//				
//		if(!JString::stristr(JString::strtolower($mapping->cacheSqlSpec), 'date'))
//			return parent::_getFormatData($value);
//
//		$value = split('-',$value);
//		$finalvalue = '';
//			
//		if(is_array($value)){
//			if( empty( $value[0] ) || empty( $value[1] ) || empty( $value[2] ) )
//				$finalvalue = '';
//			else {
//				if(JString::strlen($value[0]) == 4){
//					$year	= intval($value[0]);
//					$month	= intval($value[1]);
//					$day	= intval($value[2]);
//				}
//				else{
//					$day	= intval($value[0]);
//					$month	= intval($value[1]);
//					$year	= intval($value[2]);
//				}
//				
//				$day 	= !empty($day) 		? $day 		: 1;
//				$month 	= !empty($month) 	? $month 	: 1;
//				$year 	= !empty($year) 	? $year 	: 1970;
//				
//				$finalvalue	= $day . '-' . $month . '-' . $year;
//			}
//		}
//					
//		return $finalvalue;	
//	}

	/*
     * @since Xius-4.1	
	 */
	function _getFormatData($value)
	{
		$isMultiple = $this->pluginParams->get('customIsMultiple');
		
		//if this key can has multiple value
		if($isMultiple && stristr($this->key,'user_usergroup_map')) {
			
			$value 		= explode(',', $value);
			array_shift($value);
			array_pop($value);
						
			$newValue 	= array();
			
			if(empty(self::$joomlaGroups)) { 
				$jg = XiusHelperUsers::getJoomlaGroups();
							
				foreach ($jg as $group ) {
	
					self::$joomlaGroups[$group->id] = $group->title;
	
				}
			}
			foreach ( $value as $v ) {
				
				$newValue[] = self::$joomlaGroups[$v];
				
			}	

			return parent::_getFormatData($newValue);
		}

		if($isMultiple) {
				
			$value 		= explode(',', $value);
			
			array_shift($value);
			array_pop($value);
		}
		
		return parent::_getFormatData($value);
	}

	/*
     * @since Xius-4.1	
	 */
	function _getFormatAppliedData($value)
	{
		$isMultiple = $this->pluginParams->get('customIsMultiple');
		
		//if this key can has multiple value
		if($isMultiple && stristr($this->key,'user_usergroup_map')) {

		    if($value == 0) {
		        return parent::_getFormatData('None');
		    }

			if(empty(self::$joomlaGroups)) {
				$jg = XiusHelperUsers::getJoomlaGroups();
					
				foreach ($jg as $group ) {
			
					self::$joomlaGroups[$group->id] = $group->title;
			
				}
			}
					
			return parent::_getFormatData(self::$joomlaGroups[$value]);
		}
		
		return parent::_getFormatData($value);
	}
}
