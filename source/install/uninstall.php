<?php
// Check to ensure this file is within the rest of the framework
defined('_JEXEC') or die();

function com_uninstall()
{
	// disable plugins
	disable_plugin('xius_system');
	disable_plugin('xius');
	changeModuleState('mod_xiuslisting',0);
	changeModuleState('mod_xiussearchpanel',0);
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


function changeModuleState($moduleName,$state)
{
	$db			=& JFactory::getDBO();
	$query	= 'UPDATE ' . $db->nameQuote( '#__modules' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote($state)
          	.' WHERE '.$db->nameQuote('module').'='.$db->Quote($moduleName);

	$db->setQuery($query);		
	
	if(!$db->query())
		return false;
		
	return true;
}
