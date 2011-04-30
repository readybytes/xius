<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
//defined('_JEXEC') or die('Restricted access');

class Joomlahelper
{

	function getJoomlaFields($filter = '')
	{
		$db	= JFactory::getDBO();
			
		$userTable = new XiusTable('#__users','id', $db);
		$allColumns = $userTable->get('_db')->getTableFields('#__users');
		
		if(empty($allColumns) || empty($allColumns['#__users']) ){
			return false;
		}
			
		if(!empty($filter)){
			return $filter;
		}
			
		return $allColumns['#__users'];
	}	
}
