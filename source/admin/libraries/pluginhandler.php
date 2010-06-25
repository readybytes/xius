<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesPluginhandler
{
	
	function onUsInfoUpdated($data)
	{
		return XiusLibrariesUsersearch::updateCache();
	}
	

	function onCronRun()
	{
		return XiusLibrariesUsersearch::updateCache();
	}
	
	
	function onAfterUserSearchQueryBuild($query)
	{
		//currently this code is supposed to handle only for force search

		$user =& JFactory::getUser();

		if(XiusHelpersUtils::isAdmin($user->id))
			return true;
			
		$filter = 	array('pluginType' => 'Forcesearch');
		$forceSearchInfo	=	XiusLibrariesInfo::getInfo($filter,'AND',false);
		
		if(count($forceSearchInfo) == 0)
			return true;
			
		$plgInstance = XiusFactory::getPluginInstance('Forcesearch');
		
		if(!$plgInstance)
			return true;

		$plgInstance->addSearchToQuery($query,'');
		
		return true;
	}
	
	function changeUrl()
	{
		global $mainframe;
		$option=JRequest::getCmd('option','','GET');
		$view=JRequest::getCmd('view','','GET');
		$task=JRequest::getCmd('task','','GET');
		if($option === 'com_community' && $view === 'search' && $task === 'advancesearch')
			$mainframe->redirect(JRoute::_("index.php?option=com_xius",false));	
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
