<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class Jsuserhelper
{

	public static function getJomsocialFields($filter = '')
	{
			//$userTable = new XiusTable('#__community_users','userid');
		$allColumns = JFactory::getDBO()->getTableColumns('#__community_users');
		
		if(empty($allColumns))
			return false;
			
		if(empty($allColumns))
			return false;
			
		if(!empty($filter))
			return $filter;
			
		return $allColumns;
	}	
}
