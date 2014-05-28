<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once dirname(__FILE__).DS.'defines.php';

class Onlineuser extends XiusBase
{
	function __construct()
	{
		parent::__construct(__CLASS__);
	}
		
	function isAllRequirementSatisfy()
	{
		return $this->isAccessible();	
	}

	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
		$pluginsInfo['onlineuser'] = $this->getInfoName();
		return $pluginsInfo;
	}
	
	function getInfoName()
	{
		return XiusText::_('ONLINE_USER');
	}
	// not compitable with keyword
	public function isKeywordCompatible()
	{
		return false;
	}
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator=XIUS_LIKE,$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		if ($value === XIUS_ALL_USER )
			return true;					

		$tableMapping=$this->getTableMapping();
		$tm = array_shift($tableMapping);		
        //format the column before making the condition
		$formatedColumn = $this->formatColumn($tm, JFactory::getDBO());

		$conditions =  $formatedColumn." = 0 ";
		if ($value === XIUS_OFFLINE_USER)
			$conditions =  $formatedColumn." = 1";

		$query->where($conditions,$join);
		return true;
	}
	
	public function _getFormatAppliedData($value)
	{
		if ($value == 'all available')
		 return XiusText::_("ALL_AVAILABLE");
	}
	/**
	 * invoke when cache will being updat. 
	 * @Param 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		
		$tableMapping=$this->getTableMapping();
		
		foreach($tableMapping as $tm){
			
			$query->select(" ({$tm->tableAliasName}.{$tm->originColumnName} IS NULL  ) as {$tm->cacheColumnName} ");
			$query->leftJoin(" {$tm->tableName} as {$tm->tableAliasName} ON "
								." ( {$tm->tableAliasName}.`userid` = juser.`id` )" );
		}
		
	}
	
	/**
	 * Check user select value is valid or not.
	 * @param $value, user input value
	 */
	function validateValues($value)
	{
		return(
			$value== XIUS_ONLINE_USER
			|| $value == XIUS_OFFLINE_USER
			|| $value == XIUS_ALL_USER);
			
	}
	
	function getTableMapping()
	{
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		
	// giv a table form session table, which have unique userid.
		$object->tableName			= " (
											SELECT DISTINCT(`userid`) 
									 		FROM   `#__session`
									 		WHERE  `client_id`=0		
										)"
								;
		$object->tableAliasName 	= 'onlineuser';
		$object->originColumnName	= 'userid';
		$object->cacheColumnName	= strtolower($this->pluginType).'_'.$count;
		$object->cacheSqlSpec		= ' TINYINT(1) NOT NULL DEFAULT 1 ';
				
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}

   	
	function isExportable()
	{
		return false;
	}

}
