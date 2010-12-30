<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
//defined('_JEXEC') or die('Restricted access');

class Jsuserhelper
{

	function getJomsocialFields($filter = '')
	{
		$db	=& JFactory::getDBO();
			
		$userTable = new JTable('#__community_users','userid', $db);
		$allColumns = $userTable->_db->getTableFields('#__community_users');
		
		if(empty($allColumns))
			return false;
			
		if(empty($allColumns['#__community_users']))
			return false;
			
		if(!empty($filter))
			return $filter;
			
		return $allColumns['#__community_users'];
	}	
}
