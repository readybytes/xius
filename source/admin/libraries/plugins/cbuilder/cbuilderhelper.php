<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class Cbuilderhelper
{

	function getCBFields($filter = '')
	{
		$db	=& JFactory::getDBO();
		
		$query = "SELECT cbf.* "
		. "FROM ".$db->nameQuote('#__comprofiler_fields')." AS cbf";
		
		$db->setQuery($query);
		$fields = $db->loadObjectList();
		
		return $fields;
	}
	
	function getFieldsHTML($columnName)
	{
		$fields = Cbuilderhelper::getCBFields();
		//print_r(var_export($fields));
	}
	
	
	function filterFields(&$fields)
	{
		
	}
	
}