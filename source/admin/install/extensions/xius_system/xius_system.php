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
	
	
	// $data is un-usable
	function onUsInfoUpdated($data)
	{
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;

		require_once $includePath;
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		// we can driectly call "update cache" function
		return $plgHandler->onUsInfoUpdated($data);
	}
	
	
	function onAfterSearchQuery($data)
	{
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;

		require_once $includePath;
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		return $plgHandler->onAfterSearchQuery($data);
	}
	
	function onAfterRoute()
	{	
		$mainframe = JFactory::getApplication();

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
			$url = "index.php?option=com_community&view=users&usexius=1"; 
		
		$mainframe->redirect(XiusRoute::_($url,false));			
	}

	function onAfterXiusCacheUpdate()
	{
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		$pluginHandler->getGeocodesOfInvalidAddress();
		return;
	}
	
	function onBeforeXiusCacheUpdate()
	{
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
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
		$mainframe = JFactory::getApplication();

		//Don't run in admin
		if($mainframe->isAdmin())
			return true;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $data);	
		
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		$mainframe = JFactory::getApplication();

		//Don't run in admin
		if($mainframe->isAdmin())
			return true;
		
		if(!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php'))
			return false;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
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
		
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
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
	
	function onAfterRender()
	{		
		//Don't run in admin
		if(JFactory::getApplication()->isAdmin()){
			return true;
		}

		// Run this function when component is XiUS and
		// task is Search
		$option = JRequest::getVar('option');
		$task	= JRequest::getVar('task');
		
		if( !($option === 'com_xius' && $task === 'search'))
	    {  	
			return true;	
		}
			
		$doctype	= JFactory::getDocument()->getType();

		// Only render for HTML output
		if ( $doctype !== 'html' ){
				 return;
			 }
		
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
	
		if(!XiusLibCron::autoCronJob()){
			return;
		}
		//get xiuskey for cache update
		$setKey = XiusHelperUtils::getConfigurationParams('xiusKey',0);
		
		// Set url for Cache update
		$url = "index.php?option=com_xius&task=runCron&xiuskey=$setKey";//.JUtility::getToken()."=1";
		$cron = '<img src="'.XiusRoute::_($url).'" />';
		$body = JResponse::getBody();
		$body = str_replace('</body>', $cron.'</body>', $body);
		JResponse::setBody($body);
	}
}

