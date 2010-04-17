<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesPluginhandler
{
	
	function onUsInfoUpdated($data)
	{
		return XiusLibrariesUserSearch::updateCache();
	}
}
