<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusCache
{
	var $db				= null;
	var $_updatedTable  = null;
	var $_tableName		= null;
	var $_insertQuery	= null;
	var $error 			= null;
	
	function __construct()
	{
		$this->db 	 	    = JFactory::getDBO();
		$this->_updatedTable= '#__xius_updated_cache';
		$this->_tableName   = '#__xius_cache';
		$this->_insertQuery = 'INSERT INTO '
							   .$this->db->quoteName($this->_updatedTable).' ( ';
		$this->error 	    = XiusFactory::getInstance('error');

	}
	
	function getTableName()
	{
		return $this->_tableName;
	}
	
	function createTable()
	{
		try {
			$this->dropTable($this->_updatedTable);
		}
		catch (Exception $e){
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
			return false;
		}
		
		try {
			// Build Query	
			$createQuery = new XiusQuery();
			$createQuery = $this->buildCreateTableQuery();

			if(empty($createQuery))
			{
				return false;	
			}
		
			// Set query on Data-Base Object and Execute query
			$createQuery->dbLoadQuery()->query();
		}
		
		catch (Exception $e){
			
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
	 	  	//die($createQuery->dbLoadQuery()->_errorMsg ); //for testing purpose

			$createQuery->clear('create');
			
			return false;
		}
		
		$createQuery->clear('create');
		
		return true;	
	}

	/*
	 * Insert Into XiUS cache Table
	 */
	function insertIntoTable(XiusQuery $query,$limitReq=false,$limit = array())
	{
		$this->_insertQuery	.= $query->__toString();
		// not get any redundant data 
		$this->_insertQuery .= " GROUP BY juser.`id`";
		/*Bound result set starting from some users
		 * Limit should be configurable
		 */
		if($limitReq){
			$this->_insertQuery .= ' LIMIT '.$limit['limitStart'].' , '.$limit['limit'];
		}
		
		$this->_insertQuery .= ' )';
		
		// When Query Extermly large then required this.(For Performance)
		$this->db->setQuery("SET SESSION SQL_BIG_SELECTS=1");
		$this->db->query();

		// Insert query, set on Data-Base Object
		$this->db->setQuery($this->_insertQuery);
		
		// clear the insert query
		$this->_insertQuery = 'INSERT INTO '.$this->db->quoteName($this->_tableName).' ( ';
			
    	if(!$this->db->query()){
			JFactory::getApplication()->enqueueMessage(XiusText::_('INSERT_IN_DB_FAILED'));
			//die($this->db->_errorMsg );		//for testing purpose
		}
		
		//now drop original table and then rename the new table to xius_cache
		$this->dropTable($this->_tableName);
		if(!$this->renameTable()){
			JFactory::getApplication()->enqueueMessage(XiusText::_('INSERT_IN_DB_FAILED'));
			return false;
		}
		
		return true;
	}
	
	/*
	 * rename the new cache table 
	 */
	function renameTable()
	{
		$this->db->setQuery("RENAME TABLE ".$this->db->quoteName($this->_updatedTable)." TO ".$this->db->quoteName($this->_tableName));
		return $this->db->query();
	}
	/*
	 * Drop XiUS cache Table
	 */
	function dropTable($tableName='#__xius_cache')
	{
		$dropQuery = 'DROP TABLE IF EXISTS '.$this->db->quoteName($tableName);
		$this->db->setQuery($dropQuery);
		$this->db->query();
		return true;
	}
	/*
	 * Create XiUS-Cache Query 
	 */
	function buildCreateTableQuery($allInfo = null)
	{
		if($allInfo == null){
			$allInfo = XiusLibUsersearch::getAllInfo();

			if(empty($allInfo)){
				return false;
			}
		}

		// Get independent  Information
		$allInfo     = XiusHelperUsersearch::getSortedInfo($allInfo);
		
		$columns 	 = array();
		$columns[] = " `userid` int(21) NOT NULL PRIMARY KEY";

		foreach($allInfo as $info)
		{			
			$instance = XiusFactory::getPluginInstance('',$info->id);
			
			if(empty($instance)){
				continue;
			}
			// Get Colums according to Plugin-Table-Mapping 	
			$pluginColumns = $instance->getTableMapping();
			
			foreach($pluginColumns as $c)
			{
				if(empty($pluginColumns) && !isset($c->createCacheColumn ))
					continue;
				
				$columns[]  = " `{$c->cacheColumnName}` {$c->cacheSqlSpec} ";
			}
		}
		
		$query = new XiusQuery();
		return $query->create($this->db->quoteName($this->_updatedTable),$columns);
	}
	
}
