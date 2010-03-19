<?php

defined('_JEXEC') or die('Restricted access');

class XiusCache
{
	
	var $_tableName;
	var $createQuery;
	var $insertQuery;
	
	function __construct()
	{
		$this->_tableName = '#__xius_cache';
		
		$db =& JFactory::getDBO();
		$this->createQuery = 'CREATE TABLE IF NOT EXISTS '
						.$db->nameQuote($this->_tableName).' '
						.'`userid` int(21) NOT NULL';
	}
	
	function getTableName()
	{
		return $this->_tableName;
	}
	
	function createTable()
	{}

	function insertIntoTable()
	{}
	
	
	function buildColumn(&$cloumnDetails)
	{
		/*XITODO : use foreach with column details , it should be array of array */
		if(!in_array('columnname',$cloumnDetails)) {
			/*XITODO : set some error */
		}
		
		if(!in_array('type',$cloumnDetails))
			$cloumnDetails['type'] = 'varchar(250)';
					
		$this->createQuery .= ' , `'.$cloumnDetails['columnname'].'` '.$cloumnDetails['type'];
		
		if(in_array('default',$cloumnDetails))
			$this->createQuery .=  ' default '.$cloumnDetails['default'];
		
	}
	
}
