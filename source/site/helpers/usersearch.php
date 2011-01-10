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
		$returnInfo = array();
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
}
