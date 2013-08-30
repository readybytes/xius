<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

class XiusTable extends JTable
{
	/*
	 * @param string $table name of the table in the db schema relating to child class
	 * @param string $key name of the primary key field in the table
	 */
	function __construct($table,$key, &$db = '' )
	{
		if(empty($db)){
			$db = JFactory::getDBO();
		}

		parent::__construct($table, $key, $db);
	}
	
	public static function replacePrefix($table)
	{ 		
		if(substr($table,0,2)=='#__')
		{
			$tablePrefix = JFactory::getDBO()->getPrefix();
			$table		 = $tablePrefix.substr($table,3);
		}
		return $table;
	}
}
