<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'route.php');
require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'text.php');

function com_install()
{
	/*if(installPlugin() == false){
		JError::raiseError('INSTERR', XiusText::_("NOT ABLE TO INSTALL PLUGINS"));
		return false;
	}*/
	
	if(installExtensions() == false){
		JError::raiseError('INSTERR', XiusText::_("NOT ABLE TO INSTALL EXTENSIONS"));
		return false;
	}
	
	
	changePluginState('xius_system',true);
	changePluginState('xius',true);
	changePluginState('xius_list_privacy',true);
	return true;
}	

function installExtensions($extPath=null)
{
	//if no path defined, use default path
	if($extPath==null)
		$extPath = dirname(__FILE__).DS.'extensions';

	if(!JFolder::exists($extPath))
		return false;
	
	$extensions	= JFolder::folders($extPath);
	
	//no apps there to install
	if(empty($extensions))
		return true;

	//get instance of installer
	$installer =  new JInstaller();
	$installer->setOverwrite(true);

	//install all apps
	foreach ($extensions as $ext)
	{
		$msg = "Supportive Plugin/Module $ext Installed Successfully";

		// Install the packages
		if($installer->install($extPath.DS.$ext)==false)
			$msg = "Supportive Plugin/Module $ext Installation Failed";

		//enque the message
		JFactory::getApplication()->enqueueMessage($msg);
	}

	return true;
}	
		
	
function changePluginState($pluginname, $action=1)
{
  
	$db			=& JFactory::getDBO();
	$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
			. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
	
	$db->setQuery($query);		
	
	if(!$db->query())
		return false;
		
	return true;
}



