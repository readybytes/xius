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
	
	function _isRequired($param) {
		// Get Cron Job frequency and access time
		$xiusCronFrequency = $param->get("xiusCronFrequency");
		$xiusCronAcessTime = $param->get("xiusCronAcessTime");
		
		return ((time() - $xiusCronAcessTime) > $xiusCronFrequency);
	}	
	
}