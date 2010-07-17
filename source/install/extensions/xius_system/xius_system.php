<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgSystemxius_system extends JPlugin
{
	var $_debugMode = 0;
		
	function plgSystemxius_system( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	
	
	function onUsInfoUpdated($data)
	{
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;

		require_once $includePath;
		$plgHandler = XiusFactory::getLibraryPluginHandler();
		return $plgHandler->onUsInfoUpdated($data);
	}
	
	
	function onAfterUserSearchQueryBuild($data)
	{
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;

		require_once $includePath;
		$plgHandler = XiusFactory::getLibraryPluginHandler();
		return $plgHandler->onAfterUserSearchQueryBuild($data);
	}
	
	function onAfterRoute()
	{	
		global $mainframe;

		//Don't run in admin
		if($mainframe->isAdmin())
		return;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
			
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$xiusReplaceSearch=XiusHelpersUtils::getConfigurationParams('xiusReplaceSearch',0);

		if(!$xiusReplaceSearch)
			return;
			
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		$pluginHandler->changeUrl();
			
	}

	function onAfterXiusCacheUpdate()
	{
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		$pluginHandler->getGeocodesOfInvalidAddress();
		return;
	}
	
	function onBeforeXiusCacheUpdate()
	{
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->createGeocodeTable();		
	}
	
	function onBeforeAllListDisplay($lists)
	{
		return true;
	}
	
	function onBeforeMiniProfileDisplay($data)
	{
		return true;
	}

	function onBeforeDisplaySearchPanel($infohtml)
	{
		return true;
	}

	function onBeforeDisplayAvailableInfo($availableInfo)
	{
		return true;
	}
	
	function onBeforeDisplayProfileLink($data)
	{
		global $mainframe;

		//Don't run in admin
		if($mainframe->isAdmin())
			return;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $data);	
		
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		global $mainframe;

		//Don't run in admin
		if($mainframe->isAdmin())
			return;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $toolbar);	
		
	}
}
