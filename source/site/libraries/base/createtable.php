<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');


class XiusCreatetable extends JObject
{
	public $_tableName;
	public $_query;
	private $_count;

	function __construct($tableName)
	{
		if(empty($tableName))
			return false;

		$db = JFactory::getDBO();
		$this->_tableName	= 	$tableName;
		$this->_query		=	'CREATE TABLE IF NOT EXISTS '
								.$db->nameQuote($this->_tableName).' ( ';

		$this->_count = 0;
		return true;
	}


	function finalizeQuery()
	{
		$this->_query .= ' )';
	}


	function appendColumns($columns)
	{
		if(empty($columns))
			return false;

		foreach($columns as $c) {

			if($this->_count)
				$this->_query .= ',';

			$this->_query .= $c;
			$this->_count = $this->_count + 1;
		}

		return true;
	}

	function __toString()
	{
		$query = '';
		$query .= (string) $this->_query;
		return $query;
	}
}