<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class ProximityHelper
{	
	function getUserInfo($callObject){
		
		$userId	 = & JFactory::getUser()->id;
		$columns = $callObject->getTableMapping();
		
		if(!$columns || !is_array($columns) )
			return false;	

		foreach($columns as $value )
		     $columnsName[]= $value->cacheColumnName;
		  
		$db	= & JFactory::getDBO();
		$query=new XiusQuery();
		
		foreach ($columnsName as $column)
			$query->select($column);
			
		$query->from('#__xius_cache');
		$conditon= $db->nameQuote('userid').'='.$userId ;
		$query->where($conditon);
		$db->setQuery($query);
		//XITODO:: load row with field name
		return $db->loadRow();
	}
	
	function setUserLatLong($callObject,& $data)
	{
		$userinfo = self :: getUserInfo($callObject);		
		$data['latitude'] 	= (!is_null($userinfo[0])) ? $userinfo[0] : $data['configLat']	;
    	$data['longitude']	= (!is_null($userinfo[1])) ? $userinfo[1] : $data['configLong'];
	}
}