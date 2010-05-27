<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

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
