<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusLibCron 
{
	static function autoCronJob()
	{
		//get XiUS Configuration Model
		$xiusConfig = XiusFactory::getInstance ('configuration', 'model');
		$params		= $xiusConfig->getOtherParams('config');
		if(!self::_checkCronParams($params)){
			return false;
		}
		$configParam = $params->toArray();

		$configParam['xiusListCreator']	 = unserialize($configParam['xiusListCreator']);
		$configParam['xiusCronAcessTime']= time();
		
		$xiusConfig->save('config',$configParam);

		return true;
	}
	
	static function _checkCronParams($params)
	{
	// Check Auto-Cron Job Task Enable or not
		if(!$params->get("xiusCronJob", 0)){
			return false;
		}
		
		if(!self::_isRequired($params)){
			return false;
		}
		return true;
	}
	
	/**
	 * return cron job required or not according to Cron Frequency
	 * @param unknown_type $param
	 */
	public static function _isRequired($param) {
		// Get Cron Job frequency and access time
		$xiusCronFrequency = $param->get("xiusCronFrequency");
		$xiusCronAcessTime = $param->get("xiusCronAcessTime");
		return ((time() - $xiusCronAcessTime) > $xiusCronFrequency);
	}	
	
	/**
	 * Save Cache parameter in configuration table
	 * @param unknown_type $what: Prameter name
	 * @param unknown_type $value: Prameter value
	 */
	function saveCacheParams($what,$value)
	{		
		$config	= XiusFactory::getInstance( 'configuration' , 'Table' );
		$config->load( 'cache' );
		
		$cModel = XiusFactory::getInstance ('configuration', 'model');
		$params = $cModel->getOtherParams('cache');
		$params->set($what,$value);
		
		$config->params = $params->toString('INI');	
		$config->name='cache';
		$config->store();
		
	}
	// Return current time-stamp according to machine
	function getTimestamp()
	{
		return time();
	}
	
	/**
	 *  it return true and false according cache succefully update or not
	 */
	public static function updateCache()
	{		
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeXiusCacheUpdate' );
		
		//get database lock to restrict multi cron request
		$lock =  XiusLock::getInstance('xiusCron');
		
		if($lock->getLockResult()){
			// Set session variable thaht use in privacy plugings.
			// Check: Not any information unset during cache update 
			JFactory::getSession()->set('updateCache', true);
					
			//If we don't clear this 'updateCache' variable here then xius 
			//will not work properly(cache will not be updated)
			$cache = XiusFactory::getInstance('cache');
			if(!$cache->createTable()){
				JFactory::getSession()->clear('updateCache');
				return false;
			}
	
			$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
			
			$result =  $cache->insertIntoTable($getDataQuery);
			
			// Unset session variable
			JFactory::getSession()->clear('updateCache');
			
			// trigger the event onAfterXiusCacheUpdate		
			$dispatcher->trigger( 'onAfterXiusCacheUpdate' );
			
			return $result;
		}
		else{
			if(JFactory::getApplication()->isAdmin()){
				JFactory::getApplication()->enqueueMessage(XiusText::_("CACHE_UPDATION_IS_ALREADY_IN_PROGRESS"));
				return false;
			} 
			return true;
		}
	}
	
}