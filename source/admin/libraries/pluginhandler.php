<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesPluginhandler
{
	
	function onUsInfoUpdated($data)
	{
		return XiusLibrariesUsersearch::updateCache();
	}
	

	function onCronRun()
	{
		return XiusLibrariesUsersearch::updateCache();
	}
}
