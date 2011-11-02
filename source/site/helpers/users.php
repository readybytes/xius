<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperUsers 
{
	function getSerializedData($what)
	{
		return htmlspecialchars(serialize($what),ENT_QUOTES);
	}
	
	function getUnserializedData($what)
	{
		return unserialize(htmlspecialchars_decode($what,ENT_QUOTES));
	}
	
    function getJoomlaGroups()
	{
		$db= & JFactory::getDBO();
		
		if(XIUS_JOOMLA_15){
			$sql = ' SELECT * FROM '.$db->nameQuote('#__core_acl_aro_groups') 
				.' WHERE '.$db->nameQuote('name').' NOT LIKE "%USERS%"' 
				.' AND '.$db->nameQuote('name').' NOT LIKE  "%ROOT%"'
				.' AND '.$db->nameQuote('name').' NOT LIKE  "%Public%"' ;
		}

		else{
			$sql = ' SELECT * FROM '.$db->nameQuote('#__usergroups') 
				.' WHERE '
				//Comment This For Showing Super User
				/*.$db->nameQuote('title').' NOT LIKE "%USERS%"'.' AND '*/
				.$db->nameQuote('title').' NOT LIKE  "%ROOT%"'
				.' AND '.$db->nameQuote('title').' NOT LIKE  "%Public%"' ;
		}
		$db->setQuery($sql);
		return $db->loadObjectList(); 		
	}
}
