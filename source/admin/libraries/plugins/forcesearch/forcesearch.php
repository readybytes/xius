<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class Forcesearch extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
	
		$allInfo = XiusLibrariesInfo::getAllInfo();
		
		if(empty($allInfo))
			return false;

		$pluginsInfo = array();
			
		foreach($allInfo as $info){
			if(JString::strtolower($info->pluginType) != JString::strtolower('Forcesearch'))
				$pluginsInfo[$info->id] = $info->labelName;
		}
		
		return $pluginsInfo;
	}

	
	public function isSearchable()
	{
		return true;
	}
	

	public function getPluginParamsHtml()
	{
		$plgInstance = XiusFactory::getPluginInstanceFromId($this->key);

		if(!$plgInstance)
			return false;
			
		if(!$plgInstance->isAllRequirementSatisfy())
			continue;
			
		$inputHtml = $plgInstance->renderSearchableHtml(unserialize($this->pluginParams->get('value')));
		
		return $inputHtml;
	}
	
	
	function collectParamsFromPost(&$key,&$pluginParams,$postdata)
	{
		if(count($postdata) == 0)
			return true;	
		
		$key = $postdata['key'];
			
		$searchArray	=	XiusLibrariesUsersearch::processSearchData($postdata);
		
		if(count($searchArray) > 0){
			$pluginParamArray = $searchArray[0] ; //array('value' => $searchArray[0]->value);
			$pluginParamArray['value'] =	serialize($pluginParamArray['value']); 
			$registry	=& JRegistry::getInstance( 'xius' );
			$registry->loadArray($pluginParamArray,'xius_pluginParams');
			$pluginParams =  $registry->toString('INI' , 'xius_pluginParams' );
		}
		//$key = $postdata['key'];
		return true;
	}
	
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = XiusLibrariesInfo::getInfo($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo[0]->labelName;
			
		return false;
	}
	
	

	public function isKeywordCompatible()
	{
		return false;
	}
	
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator=XIUS_LIKE,$join='AND')
	{
		// get all information available
		$filter = 	array('pluginType' => 'Forcesearch','published' => true);
		$forceSearchInfo	=	XiusLibrariesInfo::getInfo($filter,'AND',false);
		
		if(count($forceSearchInfo) == 0)
			return false;
	
		$fsQuery = new XiusQuery();
		foreach($forceSearchInfo as $fsi){
			$plgInstance = XiusFactory::getPluginInstance($fsi->pluginType);
			if(!$plgInstance)
				break;
					
			$plgInstance->bind($fsi);
		
			$pluginParams = $plgInstance->getData('pluginParams');
			
			$this->_addSearchToQuery($fsQuery,$pluginParams,'AND');
		}
			
		$strQuery	=	$fsQuery->convertWhereIntoString();	
		if(!$strQuery)
			return false;

		$prevQuery	=	$query->convertWhereIntoString();
		if(!$prevQuery){
			$query->where( ' ( '.$strQuery.' ) ', 'AND');
			return true;
		}
		
		$condition = '( '. $prevQuery.' ) AND ( ' .$strQuery .' ) ';
		$query->clear('where');
	 	$query->where($condition, $join);		   	 
	   	return true;
	}
	
	
	function _addSearchToQuery(XiusQuery &$query,$pluginParams,$join='AND')
	{		
		$plgInstance = XiusFactory::getPluginInstanceFromId($pluginParams->get('infoid'));
		if(!$plgInstance)
			return;
		
		if(!$plgInstance->isAllRequirementSatisfy())
			continue;
		
		$plgInstance->addSearchToQuery(&$query, unserialize($pluginParams->get('value')), $pluginParams->get('operator'), $join);
		return;			
   	}
}