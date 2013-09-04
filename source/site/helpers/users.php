<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
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
