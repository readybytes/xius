<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusListHelper
{
	public static function getListData()
	{
		$user = JFactory::getUser();
		$filter='';
		
		if(!XiusHelperUtils::isAdmin($user->id)) {	
			$filter['published'] = 1;
			$privacy = XiusHelperUtils::getConfigurationParams('xiusListPrivacy',0);
			if($privacy) {
				$filter['owner'] = $user->id;
			}
		}
							
		$list = XiusLibList::getLists($filter, 'AND', false);

		// filter list according to privacy set by joomla
		XiusHelperList::filterListPrivacy($list,$user);

		return $list;
	}
}
