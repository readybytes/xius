<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusListHelper
{
	public static function getListData()
	{
		$user = JFactory::getUser();
		$filter='';
		
		if(!XiusHelperUtils::isAdmin($user->id))
			$filter['published'] = 1; 
			
		return XiusLibList::getLists($filter, 'AND', false);
	}
}
