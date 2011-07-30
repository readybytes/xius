<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is within the rest of the framework
if(!defined('_JEXEC')) die('Restricted access');

require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

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

	if (XIUS_JOOMLA_15){
			$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
					. ' SET '.$db->nameQuote('published').'='.$db->Quote('0')
			  		.' WHERE '. $db->nameQuote('element').'='.$db->Quote($pluginname);
	}	
	
	else{
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
					. ' SET '.$db->nameQuote('enabled').'='.$db->Quote('0')
			  		.' WHERE '. $db->nameQuote('element').'='.$db->Quote($pluginname) . "  AND `type`='plugin' ";
	}
	

	$db->setQuery($query);		
	if(!$db->query())
		return false;
	return true;
}


function changeModuleState($moduleName,$state)
{
	$db			=& JFactory::getDBO();
	if (XIUS_JOOMLA_15){
		$query	= 'UPDATE ' . $db->nameQuote( '#__modules' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($state)
          		.' WHERE '.$db->nameQuote('module').'='.$db->Quote($moduleName);
	}
	else{
		$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
					. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($state)
			  		.' WHERE '. $db->nameQuote('element').'='.$db->Quote($moduleName) . "  AND `type`='module' ";
	}

	$db->setQuery($query);		
	
	if(!$db->query())
		return false;
		
	return true;
}
