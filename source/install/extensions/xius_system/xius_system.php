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

	function getGeocodesOfInvalidAddress()
	{
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		
		$filter['pluginType'] = 'Proximity';
		$filter['key'] = 'google';
		// get the info details of Proximity information
		$info = XiusLibrariesInfo::getInfo($filter);
		if(!$info)
			return false;
			
		$limit = 5;
		ProximityGoogleapiHelper::createGeocodeTable();
		ProximityGoogleapiHelper::insertGeocodeRawData($info);
		
		$addresses	= ProximityGoogleapiHelper::getInvalidAddress($limit);
		$geocodes 	= ProximityGoogleapiHelper::getGeocodes($addresses);
		
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocodes);
		return true;
	}
	
}
