<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class ModXiusProximity
{
	public static function  setModuleParams($tmpParams=null)
	{
		static $params = null;
		
		if($tmpParams)
			$params = $tmpParams;
			
		return $params;
	}
	
	public static function getKeywordHtml(){
		$filter = array();
		$filter['published'] = true;
		$filter['pluginType'] = 'Keyword';
	    return ModXiusProximity::getSearchHtml($filter);
	}
	
	public static function getProximityHtml($params){
		$filter = array();
		$filter['published'] = true;
		$filter['pluginType'] ='Proximity';		
		$filter['key'] = $params->get('xius_proximity', 'information');
		
		//$filter['xius_proximity_params']
		return  ModXiusProximity::getSearchHtml($filter);		
	}
	
	public static function getSearchHtml($filter)
	{
		$info = XiusLibInfo::getInfo($filter,'AND',false);
	
		$infohtml = array();
		if(empty($info))
			return false;
					
		$plgInstance = XiusFactory::getPluginInstance('',$info[0]->id);
		if(!$plgInstance)
			continue;

		if(!$plgInstance->isAllRequirementSatisfy())
			continue;

		if(!$plgInstance->isSearchable())
			continue;

		$inputHtml = $plgInstance->renderSearchableHtml();
					
		if($inputHtml === false)
			continue;
						
		return 	array('infoid' => $info[0]->id , 'info' => $info[0] , 'label' => $info[0]->labelName , 'html' => $inputHtml, 'tooltip' => $plgInstance->getTooltip());
	}
}
