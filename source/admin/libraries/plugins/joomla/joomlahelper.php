<?php

// no direct access
//defined('_JEXEC') or die('Restricted access');

class Joomlahelper
{

	function getJoomlaFields($filter = '')
	{
		$db	=& JFactory::getDBO();
			
		$userTable = new JTable('#__users','id', $db);
		$allColumns = $userTable->_db->getTableFields('#__users');
		
		if(empty($allColumns))
			return false;
			
		if(empty($allColumns['#__users']))
			return false;
		
		return $allColumns['#__users'];
	}
	
	function getFieldsHTML($columnName)
	{
		$field = Joomlahelper::getJoomlaFields($filter);
		
		if(!$field) 		
			return false;	
			
		if($field[$columnName] == 'datetime')
			return "select date ";//XITODO : write select date html ( b/w time also)
		else
			return false;

		return false;
	}
	
}
