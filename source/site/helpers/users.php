<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperUsers 
{
	public static function getSerializedData($what)
	{
		return htmlspecialchars(serialize($what),ENT_QUOTES);
	}
	
	public static function getUnserializedData($what)
	{
		return unserialize(htmlspecialchars_decode($what,ENT_QUOTES));
	}
	
    public static function getJoomlaGroups()
	{
		$db = JFactory::getDBO();
		
		
		$sql = ' SELECT * FROM '.$db->quoteName('#__usergroups') 
			.' WHERE '
			//Comment This For Showing Super User
			/*.$db->quoteName('title').' NOT LIKE "%USERS%"'.' AND '*/
			.$db->quoteName('title').' NOT LIKE  "%ROOT%"'
			.' AND '.$db->quoteName('title').' NOT LIKE  "%Public%"' ;

		$db->setQuery($sql);
		return $db->loadObjectList(); 		
	}
}
