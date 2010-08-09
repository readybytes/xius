<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibrariesPluginhandler
{
	// XITODO :: What is use of $data here
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
		// XITODO : write message when geocodes are not found
		if(!$geocodes)
			return false;
			
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocodes);
		return true;
	}
	
	function createGeocodeTable()
	{
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		$val= ProximityGoogleapiHelper::createGeocodeTable();
		return $val;
	}
	
	
	function triggerInternelPlugin($funcName, $data)
	{
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);		
	 	if(empty($allInfo))
	 		return false;
	 		
        foreach($allInfo as $info){
			//$plgInstance = XiusFactory::getPluginInstance($info->id);
			$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
			if(!$plgInstance)
				continue;

			$plgInstance->bind($info);

			if(!$plgInstance->isAllRequirementSatisfy())
				continue;
				 
			if(method_exists($plgInstance, $funcName))
				call_user_func_array(array($plgInstance, $funcName), $data);
        }
		return true;
	}
	
	
}
