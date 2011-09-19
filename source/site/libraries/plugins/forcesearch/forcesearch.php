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
		$plgInstance = XiusFactory::getPluginInstance('',$this->key);

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
			$registry	= new JRegistry;
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
	    
		//arrange information by keys 
        usort($forceSearchInfo, "sortByKey");
	    
	    //creating groups of informations with same key 
	    $forceGrp = array();
	    for($i=0,$j=0;$i<count($forceSearchInfo);$i++)
	    {

	    	if( ($i+1) < count($forceSearchInfo) && $forceSearchInfo[$i]->key == $forceSearchInfo[$i+1]->key){
	    		 $forceGrp[$j][$i] = $forceSearchInfo[$i]; 
	    		 $forceGrp[$j][$i+1] = $forceSearchInfo[$i+1];
	    	}
	    	else{
	    		 $forceGrp[$j][$i] = $forceSearchInfo[$i];
	    		 $j++;
	    	}
	    }
	   $strQuery = null;
        //make query according to force search groups
	    foreach ($forceGrp as $group)
	    {
	    	$fgQuery = new XiusQuery();
	        foreach($group as $fg)
	    	{
              $forceSearchInstance = XiusFactory::getPluginInstance('',$fg->id);
	          if(!$forceSearchInstance->checkConfiguration('isSearchable'))
				continue;
			  $pluginParams = $forceSearchInstance->getData('pluginParams');
			  $this->_addSearchToQuery($fgQuery,$pluginParams,'OR');
		    }
		    $fgQuery	=	'('.$fgQuery->convertWhereIntoString().')';
		    if($strQuery!= null)
		     $strQuery = $strQuery.' AND '.$fgQuery;
		    else 
			 $strQuery = $fgQuery;	
	    }
				
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
		$plgInstance = XiusFactory::getPluginInstance('',$pluginParams->get('infoid'));
		if(!$plgInstance){
			return false;
		}
		
		if(!$plgInstance->isAllRequirementSatisfy()){
			return false;
			}
		
		$plgInstance->addSearchToQuery($query, unserialize($pluginParams->get('value')), $pluginParams->get('operator'), $join);
		return true;			
   	}
   	
	function isExportable()
	{
		return false;
	}
}
   //sort by key in descending order
    function sortByKey($a, $b) 
     {
          if ($a->key == $b->key)
            return 0;
         else
            return $a->key < $b->key ? 1 : -1; // reverse order
     }