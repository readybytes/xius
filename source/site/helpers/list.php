<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperList 
{
	function allowUserToAccessList($user,$allowedGroup)
	{
		// if user is not registered then he will  be treated as guest
		if(!$user->usertype)
			$user->usertype = 'Guest Only';
			
		if(in_array('All', $allowedGroup)
				||	in_array($user->usertype, $allowedGroup) 
				||  !XiusHelpersUtils::isAdmin($user->id) )
			return true;
		
		return false;
	} 
}