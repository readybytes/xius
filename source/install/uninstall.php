<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

function com_uninstall()
{
	// disable plugins
	disable_plugin('xius_system');
}

function disable_plugin($pluginname)
{
	$db			=& JFactory::getDBO();		
	$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);

	$db->setQuery($query);		
	if(!$db->query())
		return false;
	return true;
}