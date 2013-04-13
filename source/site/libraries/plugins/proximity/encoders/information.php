<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class ProximityInformationEncoder extends XiusProximityEncoder
{
	var $params = '';
	
	function __construct($params)
	{
		$this->params = $params;
	}
	
	function getTableMapping()
	{
		$tableMapping = array();
		$instanceId['latitude']		= $this->params->get('xius_proximity_latitude');
		$instanceId['longitude']	= $this->params->get('xius_proximity_longitude');
		
		foreach($instanceId as $key => $value){
			$instance		= XiusFactory::getPluginInstance('',$value);
			if(!$instance)
				return false;
			$mapping	= $instance->getTableMapping();
			$mapping[0]->createCacheColumn = false;
			array_push($tableMapping, $mapping[0]);						
		}
		
		return $tableMapping;
			
	}
	
	public function getUserData(XiusQuery &$query, $proximityTM)
	{
		return true;
	}
	
}