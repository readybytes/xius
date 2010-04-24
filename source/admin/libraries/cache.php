<?php

defined('_JEXEC') or die('Restricted access');

class XiusCache
{
	var $db				= null;
	var $_tableName		= null;
	var $createQuery	= null;
	var $insertQuery	= null;
	var $error 			= null;
	
	
	function __construct()
	{
		$this->_tableName = '#__xius_cache';
		
		$this->db =& JFactory::getDBO();
		$this->error = XiusFactory::getErrorObject();
		
		$this->insertQuery = 'INSERT INTO '.$this->db->nameQuote($this->_tableName).' ( ';
	}
	
	
	function getTableName()
	{
		return $this->_tableName;
	}
	
	function createTable($droptableReq = true)
	{
		if($droptableReq)
			$this->dropTable();
			
		if(empty($this->createQuery))
			$this->buildCreateTableQuery();
			
		$this->db->setQuery($this->createQuery->__toString());
		if($this->db->query())
			return true;
			
		$this->error->setError($this->db->ErrorMsg());
		return false;
	}

	function insertIntoTable(XiusQuery $query)
	{
		$this->insertQuery	.= $query->__toString();
		$this->insertQuery .= ' )';
		
		/*XITODO : Bound result set starting from some users
		 * Limit should be configurable
		 */
		/*$str .= ' LIMIT 10'*/
		
		$this->db->setQuery($this->insertQuery);
		
		if($this->db->query())
			return true;
			
		$this->error->setError($this->db->ErrorMsg());
		return false;
	}
	
	
	function dropTable()
	{
		$dropQuery = 'DROP TABLE IF EXISTS '.$this->db->nameQuote($this->_tableName);
		$this->db->setQuery($dropQuery);
		
		if($this->db->query())
			return true;
			
		$this->error->setError($this->db->ErrorMsg());
		return false;
	}
	
	
	/*XITODO : Modify fn to check that column name
	 * should be unique
	 */
	function buildCreateTableQuery($info = null)
	{
		if($info == null)
			$info = XiusLibrariesUsersearch::getAllInfo();
		
		if(empty($info))
			return false;

		$this->createQuery = new XiusCreateTable($this->_tableName);
		
		$columns = array();
		$columns[0] = $this->db->nameQuote('userid').' int(21) NOT NULL';
		
		$this->createQuery->appendColumns($columns);
		
		foreach($info as $i){
			$instance = XiusFactory::getPluginInstanceFromId($i->id);
			if(!$instance)
				continue;
				
			$instance->appendCreateQuery($this->createQuery);
		}
		
		$this->createQuery->finalizeQuery();
		
		return $this->createQuery->__toString();
	}
	
}
