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
			
		if($this->buildCreateTableQuery() == false)
			return false;	
			
		$this->db->setQuery($this->createQuery->__toString());
		if($this->db->query())
			return true;
			
		$this->error->setError($this->db->ErrorMsg());
		return false;
	}

	function insertIntoTable(XiusQuery $query,$limitReq=false,$limit = array())
	{
		$this->insertQuery	.= $query->__toString();
		
		/*Bound result set starting from some users
		 * Limit should be configurable
		 */
		
		if($limitReq)
			$this->insertQuery .= ' LIMIT '.$limit['limitStart'].' , '.$limit['limit'];
		
		$this->insertQuery .= ' )';

		$this->db->setQuery($this->insertQuery);
		
		// clear the insert query
		$this->insertQuery = 'INSERT INTO '.$this->db->nameQuote($this->_tableName).' ( ';
			
		if($this->db->query()){
			$affectedRows = $this->db->getAffectedRows();
			return $affectedRows;
		}
		
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
			$info = XiusLibUsersearch::getAllInfo();
		
		if(empty($info))
			return false;
		$info 	= XiusHelperUsersearch::getSortedInfo($info);

		$this->createQuery = new XiusCreatetable($this->_tableName);
		
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
