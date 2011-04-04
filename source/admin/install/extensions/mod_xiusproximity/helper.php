<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class ModXiusProximity
{
	function  setModuleParams($tmpParams=null)
	{
		static $params = null;
		
		if($tmpParams)
			$params = $tmpParams;
			
		return $params;
	}
	
	function getKeywordHtml(){
		$filter = array();
		$filter['published'] = true;
		$filter['pluginType'] = 'Keyword';
	    return ModXiusProximity::getSearchHtml($filter);
	}
	
	function getProximityHtml($params){
		$filter = array();
		$filter['published'] = true;
		$filter['pluginType'] ='Proximity';		
		$filter['key'] = $params->get('xius_proximity', 'information');
		
		//$filter['xius_proximity_params']
		return  ModXiusProximity::getSearchHtml($filter);		
	}
	
	function getSearchHtml($filter)
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
