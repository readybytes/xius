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
			
		if(!empty($filter))
			return $filter;
			
		return $allColumns['#__users'];
	}
	
	
	function getFieldsHTML($name)
	{
		return false;
	}
	
}
