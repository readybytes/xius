<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgSystemxius_system extends JPlugin
{
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

	 	// take to xius search if community search is performed
		$option=JRequest::getCmd('option','','GET');
		$view=JRequest::getCmd('view','','GET');
		$task=JRequest::getCmd('task','','GET');
		
		if($option != 'com_community' || $view != 'search' || $task != 'advancesearch')
			return;		
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
			

		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$xiusReplaceSearch=XiusHelperUtils::getConfigurationParams('xiusReplaceSearch',0);


		if(!$xiusReplaceSearch)
			return;
			
		/*
		 * If jom social is integrated with XIUS then redirect to js + XIUS URL
		 * else to XIUS
		 */
		$integrateJS =XiusHelperUtils::getConfigurationParams('integrateJomSocial',0);	
		$url = "index.php?option=com_xius";
		if($integrateJS)
			$url = "index.php?option=com_community&view=users&task=panel&usexius=1"; 
		
		$mainframe->redirect(XiusRoute::_($url,false));			
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
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->createGeocodeTable();		
	}
	
	function xiusOnBeforeAllListDisplay($lists,$loggedinUser)
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
			return true;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $data);	
		
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		global $mainframe;

		//Don't run in admin
		if($mainframe->isAdmin())
			return true;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $toolbar);	
		
	}
	
	function xiusOnAfterLoadList($lists)
	{
		$app = JFactory::getApplication();
		//Don't run in admin
		if($app->isAdmin())
				return true;
				
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
		
		$pluginHandler=XiusFactory::getLibraryPluginHandler();
		return $pluginHandler->xiusOnAfterLoadList($lists);
		
	}
	
	function xiusOnAfterLoadAllInfo($allInfo)
	{
		$app = JFactory::getApplication();

		//Don't run in admin
		if($app->isAdmin())
				return true;
		
		return true;
	}
}

