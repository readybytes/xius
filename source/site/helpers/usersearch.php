<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperUsersearch
{
	/*
	 * get the dependent information of all the information
	 */
	public static function getDependentInfo($info)
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
	public static function getSortedInfo($info)
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

	public static function trimWhiteSpace($data)
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
	 * return array which contains parent and children of each infomation
	 */
   public static  function getParentChild($reset=false)
	{
	  	static $parentChild = array();
	    if($reset == true)	
	    	$parentChild = array();

		if(!empty($parentChild))
			return $parentChild;

		$filter 			= array();
		//XiTODO:: Get all info instead of only published info
		$filter['published']= true;
		$allInfo 			= XiusLibInfo::getInfo($filter,'AND',false);
		$registry 			= new jregistry;
		foreach ($allInfo as $info)
		{
            //for forcesearch and rangesearch info
			if( $info->pluginType == 'Forcesearch' || $info->pluginType == 'Rangesearch'){
				$parentChild = self::storeParentChild($info->key,$info->id,$parentChild);
			}
			
            //for xiusemail type info
			else if($info->pluginType == 'Xiusemail'){
			    $registry->loadString($info->pluginParams,"INI");
        	    $params   = $registry->toArray();
        	    $parentChild = self::storeParentChild($params['xius_email'],$info->id ,$parentChild);
			}
			
				//for proximity info
				elseif( $info->pluginType == 'Proximity'){
				   $registry->loadString($info->pluginParams,"INI");
		    	   $params = $registry->toArray();
		    	   $proximityParams = array( 'xius_proximity_latitude',
		    	                             'xius_proximity_longitude',
		    	                             'xius_proximity_zipcode',
		    	                             'xius_proximity_country',
		    	                             'xius_proximity_state',
		    	                             'xius_proximity_city');
		    	   foreach($params as $key=>$value){
		    	   		if(!empty($value) && in_array($key ,$proximityParams)){
		    	   			$parentChild = self::storeParentChild($value, $info->id, $parentChild);
		    	   		}
		    	   }
				}
			}
		return $parentChild;
	}
	
    //stores parent and child for information
	public static function storeParentChild($parentid,$childid,$parentChild)
	{
		if(!isset($parentChild[$childid]['parent']) || !in_array($parentid, $parentChild[$childid]['parent']))
		    $parentChild[$childid]['parent'][]  = $parentid;
		if(!isset($parentChild[$parentid]['child']) || !in_array($childid, $parentChild[$parentid]['child']))   
			$parentChild[$parentid]['child'][] = $childid;
		return $parentChild;	
	}
	
    //get array of parent type infos
	public static function getParents($infoid = null)
	{
		$parents = array();
		$parentChild = self::getparentChild();
       
	    foreach ($parentChild as $key => $value){
	     	if(isset($value['parent']))
	        	foreach($value['parent'] as $parentkey=>$parentid) 
	       			$parents[$key][] = $parentid; 
         }
         //if info is given then return parent info associated with the given infoid
		if(!empty($infoid))
		 if(isset($parents[$infoid]))
			return $parents[$infoid];
		  else 
			return array();
			
		//else return all parents	
		$result = array();	
		foreach ($parents as $parentid)
			$result = array_merge($result,$parentid);	
		return $result;	
	}
	
    //get all dependent infos
	public static function getChildren($infoid = null)
	{
		$children = array();
		$parentChild = self::getparentChild();
        
		foreach ($parentChild as $key=>$value){
			if(isset($value['child']))
			  	foreach ($value['child'] as $childkey=>$childid)
			    	$children[$key][] = $childid;
		}
		//if info is given then return dependent info associated with the given infoid
		if(!empty($infoid))
		  if(isset($children[$infoid]))
			return $children[$infoid];
		  else 
			return array();
		//else return all children
		$result = array();	
		foreach ($children as $childid)
			$result = array_merge($result,$childid);	
		return $result;	
	}
}
