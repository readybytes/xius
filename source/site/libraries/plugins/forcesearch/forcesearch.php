<?php

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

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
		$allInfo = XiusLibInfo::getAllInfo();
		
		if(empty($allInfo)){
			return false;
		}

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

		if(!$plgInstance){
			return false;
			}
			
		if(!$plgInstance->isAllRequirementSatisfy()){
			return false;
			}
			
		$inputHtml = $plgInstance->renderSearchableHtml(unserialize($this->pluginParams->get('value')));
		
		return $inputHtml;
	}
	
	
	function collectParamsFromPost(&$key,&$pluginParams,$postdata)
	{
		//XiTODO:: Apply assert
		if(count($postdata) == 0)
			return true;	
		
		$key = $postdata['key'];
			
		$searchArray	=	XiusLibUsersearch::processSearchData($postdata);
		
		if(count($searchArray) > 0){
			$pluginParamArray = $searchArray[0] ; //array('value' => $searchArray[0]->value);
			$pluginParamArray['value'] = serialize($pluginParamArray['value']); 
			$registry	= JRegistry::getInstance( 'xius' );
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
		$fieldInfo = XiusLibInfo::getInfo($filter);
		
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
		$forceSearchInfo	=	XiusLibInfo::getInfo($filter,'AND',false);
		
		if(count($forceSearchInfo) == 0)
			return false;
	
		$fsQuery = new XiusQuery();
		foreach($forceSearchInfo as $fsi){
			// check for each ForceSearch Info is accessible to Joomla User type or not
			$forceSearchInstance = XiusFactory::getPluginInstanceFromId($fsi->id);
			if(!$forceSearchInstance->checkConfiguration('isSearchable'))
				continue;
				
			$pluginParams = $forceSearchInstance->getData('pluginParams');
			$this->_addSearchToQuery($fsQuery,$pluginParams,'AND');
		}
			
		$strQuery	=	$fsQuery->convertWhereIntoString();	
		if(!$strQuery){
			return false;
		}

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
		if(!$plgInstance){
			return false;
		}
		
		if(!$plgInstance->isAllRequirementSatisfy()){
			return false;
			}
		
		$plgInstance->addSearchToQuery($query, unserialize($pluginParams->get('value')), $pluginParams->get('operator'), $join);
		return true;			
   	}
}
