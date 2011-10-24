<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

class XiusCache
{
	var $db				= null;
	var $_tableName		= null;
	var $_insertQuery	= null;
	var $error 			= null;
	
	function __construct()
	{
		$this->db 	 	    = JFactory::getDBO();
		$this->_tableName   = '#__xius_cache';
		$this->_insertQuery = 'INSERT INTO '
							   .$this->db->nameQuote($this->_tableName).' ( ';
		$this->error 	    = XiusFactory::getInstance('error');

	}
	
	function getTableName()
	{
		return $this->_tableName;
	}
	
	function createTable()
	{
		$this->dropTable();
		
		// Build Query	
		$createQuery = new XiusQuery();
		$createQuery = $this->buildCreateTableQuery();

		if(empty($createQuery))
		{
			return false;	
		}
		// Set query on Data-Base Object and Execute query
		$createQuery->dbLoadQuery()->query();
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
		$this->_insertQuery = 'INSERT INTO '.$this->db->nameQuote($this->_tableName).' ( ';
			
		if(!$this->db->query())
			JFactory::getApplication()->enqueueMessage(XiusText::_('INSERT_IN_DB_FAILED'));
		$affectedRows = $this->db->getAffectedRows();
		return $affectedRows;
	}
	
	/*
	 * Drop XiUS cache Table
	 */
	function dropTable()
	{
		$dropQuery = 'DROP TABLE IF EXISTS '.$this->db->nameQuote($this->_tableName);
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
		return $query->create($this->db->nameQuote($this->_tableName),$columns);
	}
	
}
