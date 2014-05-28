<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// XITODO:: Change Class name
class ProximityHelper
{	
	public static function getUserInfo($callObject){
		
		$userId	 = JFactory::getUser()->id;
		$columns = $callObject->getTableMapping();
		
		if(!$columns || !is_array($columns) )
			return false;	

		foreach($columns as $value )
		     $columnsName[]= $value->cacheColumnName;
		  
		$db	= JFactory::getDBO();
		$query=new XiusQuery();
		
		foreach ($columnsName as $column)
			$query->select($column);
			
		$query->from('#__xius_cache');
		$conditon= $db->quoteName('userid').'='.$userId ;
		$query->where($conditon);
		$db->setQuery($query);
		//XITODO:: load row with field name
		return $db->loadRow();
	}
	
	public static function setUserLatLong($callObject,& $data)
	{
		
		$userinfo = self :: getUserInfo($callObject);

		//Set default values
		$data['latitude']  = $data['configLat']	;
		$data['longitude'] = $data['configLong'];

		// if User location information does not exist
		//if($userinfo==false || count($userinfo) != 2){			
          if(empty($userinfo))
		    return;
		

		if(!is_null($userinfo[0]) && $userinfo[0] !== '')
			$data['latitude'] 	= $userinfo[0] ;
	
		if(!is_null($userinfo[1]) && $userinfo[1] !== '')
			$data['longitude']	= $userinfo[1] ;

		return;
	}
}