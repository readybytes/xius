<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once dirname(__FILE__).DS.'jsuserhelper.php';
require_once dirname(__FILE__).DS.'defines.php';

class Jsuser extends XiusBase
{
    static $defaultAvatars=array();

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = XiusHelperUtils::isComponentExist('com_community',true) ? true : false;
		return $isExist;
	}
	
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$fields = Jsuserhelper::getJomsocialFields();
		
		if(empty($fields))
			return false;

		$pluginsInfo = array();
			
		foreach($fields as $k => $v){
		//	if($k == '' || $k == 'password'
			//		|| $k == 'activation' || $k == 'sendEmail')
				//continue;
				
			$pluginsInfo[$k] = $k;
		}
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
			
		if($this->key == 'avatar' && $value == XIUS_ALLUSER )
			return true;
		
		$db = JFactory::getDBO();
		if(is_array($value))
			return false;

		//get all cache columns 
		$columns = $this->getTableMapping();
		
		if(!$columns)
			return false;
			
		foreach($columns as $c){
            //format the column before making the condition
			$formatedcolumn = $this->formatColumn($c, $db);
			$conditions     =  $formatedcolumn.' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
            if($operator != XIUS_LIKE)
			  $conditions = $formatedcolumn.' '.$operator.' '.$db->Quote($this->formatValue($value));
				
			$query->where($conditions,$join);
		}		
		return true;
	}
	
        function _getFormatAppliedData($value)
	{
		if($value == 'All Users')
		 return XiusText::_('ALL_USERS');
		return parent::_getFormatAppliedData($value); 
	}

   //formats the column according to the type of key
    function formatColumn($column , $db)
	{
		if($this->key == 'posted_on')
		   return "DATE_FORMAT(".$db->quoteName($c->cacheColumnName).", '%d-%m-%Y') ";

		return parent::formatColumn($column, $db);
		
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
							 ." ON ( {$tm->tableAliasName}.`userid` = juser.`id` ) "
							);
		}
	}
	
	function getTableMapping()
	{
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		if($this->key=='avatar') 
			$object->tableName = self::getTable();
		
		$object->tableAliasName 	= "communityusers{$this->key}_$count";
		$object->originColumnName	= $this->key;
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec 		= $this->getCacheSqlSpec($this->key);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getInfoName()
	{
		//$filter = array();
		$filter = $this->key;
		$fieldInfo = Jsuserhelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo;
			
		return false;
	}
	
	function getCacheSqlSpec($key)
	{
		if($key == 'posted_on')
			return 'datetime NOT NULL'; 
		
		if($key == 'userid')
			return 'int(21) NOT NULL';
			
		if ($key == 'avatar')
		    return 'TINYINT(1) NOT NULL DEFAULT 0';
		    	
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
		if($this->key === 'thumb'){ 
				$value= '<img src="' .JURI::base().$value. '"/>';
				return $value;
		}
		
		if($this->key === 'avatar'){
			if(is_numeric($value))
			 {		
			   if($value == 0){
				 return XIUS_AVATAR_USER;}
			  else if($value == 1){
				 return XIUS_DEFAULT_AVATAR_USER;}
            }
           return $value;
		}
		
		if($this->key === 'profile_id')
		{
			if($value==0)
 				return $profile->name=XiusText::_("DEFAULT_PROFILE");;
			
 			$profileTypes= CFactory::getModel('profile')->getProfileTypes();
 			foreach($profileTypes as $profile){
 				if($profile->id == $value)
 					return $profile->name;
 			}
		}
		
		if($this->key != 'posted_on')
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
	
	public function validateValues($value)
	{
		if($this->key == "profile_id")
		 	return is_numeric($value)? true :false;
		else 
			return parent::validateValues($value);	
	}
	
	public function fetchDefaultAvatar()
	{
		if(!empty($defaultAvatars))
			return $defaultAvatars;
		// Default JS avatar
		$defaultAvatars[]   = DEFAULT_USER_AVATAR;
		$defaultAvatars[]   = XIUS_DEFAULT_THUMB; //default avatar for JS2.4
		
		//if xipt is unhooked
		$isSystemPlg=XiusHelperUtils::isPluginInstalledAndEnabled('xipt_system',true);
		$isCommPlg=XiusHelperUtils::isPluginInstalledAndEnabled('xipt_community',true);
		
		if($isCommPlg && $isSystemPlg)
		{
		  $profiletypes = XiusHelperXiptwrapper::getProfileTypeIds();
		   foreach($profiletypes as $profileType)
			 $defaultAvatars[] = $profileType->avatar;
		}
		
		return $defaultAvatars;

	}
	
	public function getTable(){
		return  "(
				  SELECT `userid`, CASE `avatar` "
				  . self::getCondition()." as avatar
				   FROM `#__community_users`
				)";
	}
	
	function getCondition() {
		$defaultAvatars = self::fetchDefaultAvatar();
		$condition 		= " WHEN '' THEN 1 ";

		foreach($defaultAvatars as $avatar)
			$condition .= " WHEN '{$avatar}' THEN 1 ";
			
		$condition .= " ELSE  0  END";
		return $condition;
	}
}
