<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusListHelper
{
	function getListData()
	{
		$user = JFactory::getUser();
		$filter='';
		
		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1; 
			
		return XiusLibrariesList::getLists($filter, 'AND', false);
	}
}
