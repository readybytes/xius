<?php
defined('_JEXEC') or die('Restricted access');

function com_install()
{
	/*if(installPlugin() == false){
		JError::raiseError('INSTERR', JText::_("NOT ABLE TO INSTALL PLUGINS"));
		return false;
	}*/
	
	if(installExtensions() == false){
		JError::raiseError('INSTERR', JText::_("NOT ABLE TO INSTALL EXTENSIONS"));
		return false;
	}
	
	
	changePluginState('xius_system',true);
	
	
	return true;
}

	
/*function installPlugin()
{		
	JLoader::import( 'com_xius.libraries.dscinstaller', JPATH_ADMINISTRATOR.DS.'components' );
		
	$installer =& JInstaller::getInstance();
	$manifest = & $installer->getManifest();
	// Get the manifest document root element
	$root =& $manifest->document;
	// Get the element of the tag names
	$element =& $root->getElementByPath('plugins');
	
	if (!is_a($element, 'JSimpleXMLElement') || !count($element->children())) {
		// Either the tag does not exist or has no children therefore we return zero files processed.
		return true;
	}
		// Get the array of parameter nodes to process
	$plugins = $element->children();
	if (count($plugins) == 0) {
		// No params to process
		return true;
	}

	// Process each plugin in the $plugins array.
	foreach ($plugins as $plugin)
	{
		$pname		= $plugin->attributes('plugin');
		$ppublish	= $plugin->attributes('publish');
		$pgroup		= $plugin->attributes('group');
			
		// Set the installation path
		if (!empty($pname) && !empty($pgroup)) {
			$installer->setPath('extension_root', JPATH_ROOT.DS.'plugins'.DS.$pgroup);
		} else {
			$installer->abort(JText::_('PLUGIN').' '.JText::_('INSTALL').': '.JText::_('INSTALL PLUGIN FILE MISSING'));
			return false;
		}
		
		// fire the dioscouriInstaller with the foldername and folder entryType
		 
		$pathToFolder = $installer->getPath('source').DS.$pname;
		$dscInstaller = new dscInstaller();
		if ($ppublish) {
			$dscInstaller->set( '_publishExtension', true );
		}
		$result = $dscInstaller->installExtension($pathToFolder, 'folder');
		
		// track the message and status of installation from dscInstaller
		if ($result) {
			
			$msg = JText::_( "INSTALLED" );
		} else {
			
			$msg = JText::_( "FAILED" );
			$error = $dscInstaller->getError();
			$msg .= " - ".$error;	
			return false;
		}
	}
	return true;
}*/
	

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
		$msg = JText::sprintf("Supportive Plugin/Module %S Installed Successfully",$ext);

		// Install the packages
		if($installer->install($extPath.DS.$ext)==false)
			$msg = JText::sprintf("Supportive Plugin/Module %S Installation Failed",$ext);

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



