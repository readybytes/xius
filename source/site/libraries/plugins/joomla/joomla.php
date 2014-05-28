<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'joomla'.DS.'joomlahelper.php';

class Joomla extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	
	public function getAvailableInfo()
	{
		$fields = xiusJoomlahelper::getJoomlaFields();
		
		if(empty($fields))
			return false;

		$pluginsInfo = array();
			
		foreach($fields as $k => $v){
			if($k == 'params' || $k == 'password'
					|| $k == 'activation' || $k == 'sendEmail')
				continue;
				
			$pluginsInfo[$k] = $k;
		}
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false){
			return false;
		}
		
		$db = JFactory::getDBO();
//		if(is_array($value)){
//			return false;
//		}

		//get all cache columns 
		$columns = $this->getTableMapping();
		
		if(empty($columns)){
			return false;
		}
			
		foreach($columns as $c){

            //format the column before making the condition
			$formatedColumn = $this->formatColumn($c, $db);

            //make the condition according to the type of key
			$conditions     =  $formatedColumn.' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
		    if( $this->key == 'registerDate' || $this->key == 'lastvisitDate')
				$conditions = $formatedColumn.$operator.' '.$db->Quote($this->formatValue($value));

			if( is_numeric($value) && $operator != XIUS_LIKE )
				$conditions =  $formatedColumn.' '.$operator.' '.$db->Quote($this->formatValue($value));
			$query->where($conditions,$join);
		}		
		return true;
	}
	
    //format column according to the type of key
	function formatColumn($column , $db)
	{
		if($this->key == 'registerDate' || $this->key == 'lastvisitDate')
		  return "DATE_FORMAT(".$db->quoteName($column->cacheColumnName).", '%d-%m-%Y') ";

		return parent::formatColumn($column, $db);
	}
	
    function formatValue($value)
	{
       //if J1.5 then format value from groupid to groupname 
       //because groupname is saved in cache table
       if(XIUS_JOOMLA_15 && $this->key == 'usertype'){
      	$groups      =  XiusHelperUsers::getJoomlaGroups();
      	foreach ($groups as $group){
      		if($group->id == $value)
      		 	return $group->{XIUS_JOOMLA_GROUP_VALUE}; 
      	}
       }
		
       //In case of multiselect layout of usertype(Force search)
       // $value is an array of array
	   if($this->key == 'usertype' && isset($value['param'][0])){
	  	 return $value['param'][0];
	   }	
	  return parent::formatValue($value);
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		
		$tableMapping = $this->getTableMapping();
		
		foreach( $tableMapping as $tm){
			$query->select( " {$tm->tableAliasName}.{$tm->originColumnName} "
							." as {$tm->cacheColumnName} "
						  );
			$query->leftJoin( " {$tm->tableName}  as {$tm->tableAliasName}   "
							 ." ON ( {$tm->tableAliasName}.`".($tm->tableName == '`#__user_usergroup_map`'?'user_id':'id')."` = juser.`id` ) "
						    );
		}
	}
	
	function getTableMapping()
	{
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		
		$object->tableName		    = '`#__users`';
		$object->originColumnName	= $this->key;

		//in case of J1.7 user's groups should be taken from #__user_usergroup_map
		if(!XIUS_JOOMLA_15  && $this->key === 'usertype'){
			$object->tableName		    = '`#__user_usergroup_map`';
			$object->originColumnName	= 'group_id';
        }

		$object->tableAliasName 	= "joomlauser{$this->key}_$count";
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec 		= $this->getCacheSqlSpec($this->key);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getInfoName()
	{
		if(empty($this->key)){
			return false;
		}
		return	$this->key;
	}
	
	function getCacheSqlSpec($key)
	{
		if($key == 'registerDate' || $key == 'lastvisitDate'){
			return 'datetime NOT NULL'; 
		}
		
		if($key == 'id'){
			return 'int(21) NOT NULL';
		}
			
		if($key == 'block'){
			return 'tinyint(4) NOT NULL';
		}
	
		return parent::getCacheSqlSpec($key);
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
	
	
	/* formatting displaying output */
	public function _getFormatData($value)
	{
	    if($this->key === 'usertype'){
			$groups      = XiusHelperUsers::getJoomlaGroups();
			foreach ($groups as $group){
				if($group->id == $value){
					return $group->{XIUS_JOOMLA_GROUP_VALUE};
				}
			}
		}

		if($this->key != 'registerDate' && $this->key != 'lastvisitDate'){
			return parent::_getFormatData($value);
		}
		
		$value = explode('-',$value);
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
	
	public function _getFormatAppliedData($value)
	{
		if($this->key === 'block'){
			$val[0] = XiusText::_('UN_BLOCKED');
			$val[1] = XiusText::_('BLOCKED');
			return $val[$value];
		}
			
		return $this->_getFormatData($value);
	}

	function validateValues($value)
	{
		if($this->key == 'usertype' && (string)$value == '0'){
		   return false;
		}
		return parent::validateValues($value);
	}
}
