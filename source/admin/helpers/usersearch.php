<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusHelpersUsersearch
{

	function getDependentInfo($info)
	{
		/*
		 * get the dependent information of al the information
		 */
		foreach($info as $i){
			if(is_array($i))
				$instance = XiusFactory::getPluginInstanceFromId($i['id']);
			else if(is_object($i)){
				$instance = XiusFactory::getPluginInstanceFromId($i->id);
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
		$availInfo	= array(-1);
		$dependentInfo  = XiusHelpersUsersearch::getDependentInfo($info);
		
		while(count($info)>0)
		{
			$count =count($info);
			
			for($i=0 ; $i<$count ; $i++)
			{
				$dependOn = $dependentInfo[$info[$i]->id];
				if(XiusHelpersUsersearch::isDependAleardyExists($dependOn,$availInfo))
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
	
	function isDependAleardyExists($depend, $availInfo)
	{
		$diff = array_diff($depend, $availInfo);
		if(empty($diff))
			return true;
		
		return false;
			
	}	
}
