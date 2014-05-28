<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibPluginhandler
{
	// XITODO :: What is use of $data here
	function onUsInfoUpdated($data)
	{
		return XiusLibCron::updateCache();
	}
	

	/**
	 * its use on plugin trigger
	 * (When run community cron then it trigger )
	 */
	function onCronRun()
	{
		return XiusLibCron::updateCache();
	}
	
	/**
	 * Trigger plugin call this function 
	 * @param unknown_type $query have XiUSQuery reference
	 */
	function onAfterSearchQuery($query,$sort, $dir)
	{
		//currently this code is supposed to handle only for force search
		$user = JFactory::getUser();

		// on admin not apply any force search
		if(XiusHelperUtils::isAdmin($user->id)){
			return true;
		}
			
		$filter = 	array('pluginType' => 'Forcesearch');
		$forceSearchInfo	=	XiusLibInfo::getInfo($filter,'AND',false);
		
		if(count($forceSearchInfo) == 0){
			return true;
		}
		//get plugin instance
		$plgInstance = XiusFactory::getPluginInstance('Forcesearch');
		if(!$plgInstance){
			return true;
		}

		$plgInstance->addSearchToQuery($query,'');
		return true;
	}
	
	/**
	 * trigger after cache update
	 */
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

		if(JFactory::getConfig()->get('debug') == 1 && !$geocodes){
			JError::raiseWarning(1001,XiusText::_('WARNING_FOR_NOT_FOUND_GEOCODE'));
			return false;
		}	
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocodes);
		return true;
	}
	/*
	 * Trigger On-Before-cache update 
	 */
	function createGeocodeTable()
	{
		require_once ( XIUS_PLUGINS_PATH.DS. 'proximity' .DS.'googleapihelper.php');
		$val= ProximityGoogleapiHelper::createGeocodeTable();
		return $val;
	}
	
	/**
	 * trigger it before dispaly information and toolbar
	 * @param $funcName
	 * @param $data
	 */
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
		$user  = JFactory::getUser();
		return XiusHelperList::filterListPrivacy($lists,$user);			
	}
	
	/**Valid only for JS 2.2.X
	 * Change JS toolbar search option according to state
	 * @param unknown_type $state is a boolean value.
	 */
	 
	public static function setJSToolbarState($state = 0) {
	 	
		$config	   = CFactory::getConfig();
	 	$queryObj  = new XiusQuery;
	 	$condition ="(link = 'index.php?option=com_community&view=search&task=advancesearch'".
	 				" OR ".
	 				"link ='index.php?option=com_community&view=search')";
		$queryObj->update('#__menu')
	 			 	->set('published ='. $state)
					->where("menutype = '". $config->get( 'toolbar_menutype')."'")
	 			 	->where('client_id = 0')
					->where($condition)	 			 			  
	 			 	->dbLoadQuery()->query();

	}
	
}
