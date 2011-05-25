<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibCron 
{
	static function autoCronJob()
	{
		//get XiUS Configuration Model
		$xiusConfig = XiusFactory::getInstance ('configuration', 'model');
		$params		= $xiusConfig->getOtherParams('config');

		// Check Auto-Cron Job Task Enable or not
		if(!$params->get("xiusCronJob", 0)){
			return false;
		}
		
		if(!self::_isRequired($params)){
			return false;
		}

		$configParam = $params->toArray();

		$configParam['xiusListCreator']	 = unserialize($configParam['xiusListCreator']);
		$configParam['xiusCronAcessTime']= time();
		
		$xiusConfig->save('config',$configParam);

		return true;
	}
	/**
	 * return cron job required or not according to Cron Frequency
	 * @param unknown_type $param
	 */
	function _isRequired($param) {
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
	function updateCache()
	{		
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeXiusCacheUpdate' );
		
		// Set session variable thaht use in privacy plugings.
		// Check: Not any information unset during cache update 
		JFactory::getSession()->set('updateCache', true);
		
		$cache = XiusFactory::getInstance('cache');
		if(!$cache->createTable()){
			return false;
		}

		$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
		
		$result =  $cache->insertIntoTable($getDataQuery);
		
		// Unset session variable
		JFactory::getSession()->clear('updateCache', true);
		
		// trigger the event onAfterXiusCacheUpdate		
		$dispatcher->trigger( 'onAfterXiusCacheUpdate' );
		return $result;
	}
	
}