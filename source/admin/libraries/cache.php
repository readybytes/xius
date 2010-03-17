<?php

defined('_JEXEC') or die('Restricted access');

class XiusCache
{
	
	var $createQuery;
	var $insertQuery;
	
	function __construct()
	{
		$db =& JFactory::getDBO();
		$this->createQuery = 'CREATE TABLE IF NOT EXISTS '
						.$db->nameQuote('#__xius_cache').' '
						.'`userid` int(11) NOT NULL';
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
