<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';

class Keyword extends XiusBase
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

		$pluginsInfo['keywordsearch'] = 'Keyword';
		
		
		return $pluginsInfo;
	}
			
	/*this function should call after setting key */
	function getInfoName()
	{
		return 'Keyword';
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator=XIUS_LIKE,$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		// get all information available
		$allInfo = XiusLibInfo::getInfo(array(),'AND',false);
		
		if(!empty($allInfo)){
			$strQuery = $this->_addSearchToQuery($allInfo, $value);		
		 	$query->where( ' ( '.$strQuery.' ) ', $join);		   	 
		   	return true;
        }
        return false;
	}
	
	
	function _addSearchToQuery($allInfo, $value)
	{		
		// create a tempQuery to generate one element of where for all info
		$tempQuery = new XiusQuery();
		// exlpode the value by space or comma whatever separator is used
		// so that multiple search can be done
		if(strstr($value,",")){
			$value	= explode(',', $value);
		}
		else{
			$value	= explode(' ', $value);
		}
		
		// XITODO : convert this function to general function
		// search according to special value for specific info
		/*$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeKeywordSearch',array( &$allInfo, &$value ));
		*/
       	foreach($allInfo as $info){
       		foreach($value as $val){
       			if($info->pluginType == $this->pluginType && $info->key == $this->key)
       				continue;
				$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
				if(!$plgInstance)
					continue;
						
				$plgInstance->bind($info);

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;
				
				if(!$plgInstance->isSearchable())
					continue;
					
				if(!$plgInstance->isKeywordCompatible())
					continue;
					
				$plgInstance->addSearchToQuery($tempQuery, $val, XIUS_LIKE, 'OR');			
		   	}
       	}
        	// convert  all element into one element so that more than one keyword search can be combined 
		return $tempQuery->convertWhereIntoString();	
	}
	
	function isExportable()
	{
		return false;
	}
}
