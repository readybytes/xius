<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

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
			$instance		= XiusFactory::getPluginInstanceFromId($value);
			if(!$instance)
				continue;
			// XITODO : test it	
			array_merge($tableMapping,$instance->getTableMapping());			
		}
		
		return $tableMapping;
			
	}
	
	public function getUserData(XiusQuery &$query, $proximityTM)
	{
		return true;
	}
	
}