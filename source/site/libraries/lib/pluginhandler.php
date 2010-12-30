<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibPluginhandler
{
	// XITODO :: What is use of $data here
	function onUsInfoUpdated($data)
	{
		return XiusLibUsersearch::updateCache();
	}
	

	function onCronRun()
	{
		return XiusLibUsersearch::updateCache();
	}
	
	
	function onAfterUserSearchQueryBuild($query)
	{
		//currently this code is supposed to handle only for force search

		$user =& JFactory::getUser();

		if(XiusHelperUtils::isAdmin($user->id))
			return true;
			
		$filter = 	array('pluginType' => 'Forcesearch');
		$forceSearchInfo	=	XiusLibInfo::getInfo($filter,'AND',false);
		
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
		require_once ( XIUS_PLUGINS_PATH.DS. 'proximity' .DS.'googleapihelper.php');
		
		$filter['pluginType'] = 'Proximity';
		$filter['key'] = 'google';
		// get the info details of Proximity information
		$info = XiusLibInfo::getInfo($filter);
		if(!$info)
			return false;
			
		$limit = 5;
		ProximityGoogleapiHelper::createGeocodeTable();
		ProximityGoogleapiHelper::insertGeocodeRawData($info);
		
		$addresses	= ProximityGoogleapiHelper::getInvalidAddress($limit);
		$geocodes 	= ProximityGoogleapiHelper::getGeocodes($addresses);
		// XITODO : write message when geocodes are not found
		if(!$geocodes){
			JError::raiseWarning(1001,XiusText::_('WARNING_FOR_NOT_FOUND_GEOCODE'));
			return false;
		}	
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocodes);
		return true;
	}
	
	function createGeocodeTable()
	{
		require_once ( XIUS_PLUGINS_PATH.DS. 'proximity' .DS.'googleapihelper.php');
		$val= ProximityGoogleapiHelper::createGeocodeTable();
		return $val;
	}
	
	
	function triggerInternelPlugin($funcName, $data)
	{
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibInfo::getInfo($filter,'AND',false);		
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
	
	function xiusOnAfterLoadList(&$lists)
	{
		$user  = & JFactory::getUser();
		return XiusHelperList::filterListPrivacy($lists,$user);			
	}
	
}
