<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusHelperUsersearch
{
	/*
	 * get the dependent information of all the information
	 */
	function getDependentInfo($info)
	{
		foreach($info as $i){
			if(is_array($i))
				$instance = XiusFactory::getPluginInstance('',$i['id']);
			else if(is_object($i)){
				$instance = XiusFactory::getPluginInstance('',$i->id);
			}
			
			$dependentInfo[$i->id] = $instance->getDependentInfo();
		}
		return $dependentInfo;	
	}
	
	/*
	 * sort the information according to their dependency
	 */
	function getSortedInfo($info)
	{
		$returnInfo 	= array();
		$jsFiledsInfo	= Array(); 
		//$origInfo	= clone($info);
		//XiTODO:: remove magic num 
		$availInfo	= array(-1);
		$dependentInfo  = XiusHelperUsersearch::getDependentInfo($info);
		
		while(count($info)>0)
		{
			$count =count($info);
			
			for($i=0 ; $i<$count ; $i++)
			{
				$dependOn = $dependentInfo[$info[$i]->id];
				// is Depend Aleardy Exists
				$diff 	  = array_diff($dependOn,$availInfo);
				if(empty($diff))
				{
					$availInfo[] = $info[$i]->id;
					$returnInfo[] = clone($info[$i]);
					unset($info[$i]);
				}				
			}
			
			$info = array_values($info);
		}

		//JSFields must high to prioritize in column seq.
		foreach($returnInfo as $index=>$info)
		{
			if($info->pluginType == 'Jsfields')
			{
					$jsFiledsInfo[] = clone($returnInfo[$index]);
					unset($returnInfo[$index]);
			}
		}
		if(!empty($jsFiledsInfo))
		{
			foreach($jsFiledsInfo as $info)
				array_unshift($returnInfo,$info);
		}

		return $returnInfo;
	}

	function trimWhiteSpace($data)
	{
		//Handle object Data
		if(is_object($data))
			return $data;
		
		//Handle Scalar Data
		if(is_scalar($data)){
			if(is_string($data))
				return JString::trim($data);
			return $data;	
		}
		
		//Handle Array data
		foreach ($data as $key=>$value){
		   if(is_array($value)){
		   	$value		   = self::trimWhiteSpace($value);
		   	$newdata[$key] = $value;
		   }
		   else
		    $newdata[$key] = JString::trim($value);
		}
		return $newdata;		
	}

	/*
	 * return array of all the parent infomations
	 */
	function getParentInfo($reset=false)
	{
		static $parents = array();
	    if($reset == true)	$parents=array();

		if( $parents != array() && isset($parents))
			return $parents;

		$filter 			= array();
		$filter['published']= true;
		$allInfo 			= XiusLibInfo::getInfo($filter,'AND',false);
		$count              = 0;
		foreach ($allInfo as $info)
		{
			//for plugin type Forcesearch and Rangesearch
			if( $info->pluginType == 'Forcesearch' || $info->pluginType == 'Rangesearch')
			  $parents[$count++] = $info->key;
			
			
			//for plugin type Proximity
			if( $info->pluginType == 'Proximity'){
			   $registry = new JRegistry;
			   $registry->loadINI($info->pluginParams);
        	   $params = $registry->toArray();
        	   		
		        /*XITODO : 
		         * clean this code
		         */
        	   	foreach($params as $key=>$value){ 
        	   		if(!empty($value) && ($key == 'xius_proximity_latitude'  ||
        	   		                      $key == 'xius_proximity_longitude' || 
        	   		                      $key == 'xius_proximity_zipcode'   ||
        	   		                      $key == 'xius_proximity_country'   ||
        	   		                      $key == 'xius_proximity_state'     ||
        	   		                      $key == 'xius_proximity_city'))
        	   		   $parents[$count++] = $value;
        	   	}
        	}
			
			//for plugin type xiusemail
			if($info->pluginType == 'Xiusemail'){
			   $registry = new JRegistry;
			   $registry->loadINI($info->pluginParams);
        	   $params = $registry->toArray();
        	   $parents[$count++] = $params['xius_email'];
			}

		}
        return $parents;
	}
}
