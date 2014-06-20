<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once(dirname(__FILE__) . DS . 'defines.php');

class ProximityGoogleapiHelper extends JControllerLegacy 
{

	public static function getGoogleAPIContent($url)
	{
		if (!$url)
			return false;
		
		if (function_exists('curl_init')){
			$ch			= curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$response	= curl_exec($ch);
			curl_close($ch);
			return $response;
		}
		return false;
	}
	
	public static function _getGeocodes($address)
	{
		require_once (dirname(__FILE__).DS.'json.php');
		$url = XIUS_GEOCODE_URL . 'address='.urlencode($address) .'&sensor=false';
		$content = ProximityGoogleapiHelper::getGoogleAPIContent($url);
		
		$status = null;	
		if(empty($content))
			return false;
				
		$json = new Services_JSON();
		$status = $json->decode($content);

		if($status->status != 'OK' && JFactory::getConfig()->get('debug') == 1){
			JFactory::getApplication()->enqueueMessage($status->status);
		}

		if($status->status == 'OK'){
			$data['latitude']  = $status->results[0]->geometry->location->lat;
			$data['longitude'] = $status->results[0]->geometry->location->lng;
			return $data; 
		}
		
		return array('latitude'=>NULL, 'longitude'=>NULL);
	}
	
	public static function getGeocodes($addresses)
	{		
		if(!array($addresses))
			return false;
		$data = Array();
		foreach($addresses as $ad){
			if(!isset($ad->address) || !$ad->address)
				continue;
				
			$geocodes = ProximityGoogleapiHelper::_getGeocodes($ad->address);
			$data[$ad->id]	= $geocodes;
		}
		return $data;
	}
	
	public static function createGeocodeTable()
	{
		$query =  " CREATE TABLE IF NOT EXISTS `#__xius_proximity_geocode` ( 
				 `id` int(10) unsigned NOT NULL auto_increment,
				 `address` varchar(250) NOT NULL,
				 `latitude` float(10,6) DEFAULT NULL,
				 `longitude` float(10,6) DEFAULT NULL,
				 `valid` tinyint(1) NOT NULL default '0' , 
				 PRIMARY KEY  (`id`) 
				 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		
		$db = JFactory::getDBO();
		$db->setQuery( $query );
		return $db->query();		
	}
	
	public static function insertGeocodeRawData($info)
	{
		// create instance of proximity information plugin
		$instance = XiusFactory::getPluginInstance('',$info[0]->id);
		if(!$instance)
			return false;

		$tableMapping = $instance->getTableMapping();
		if(empty($tableMapping))
			return false;
			
		
		
		$selectCacheCol		= $tableMapping[2]->cacheColumnName;
		$selectGeocodeCol	= 'address';
		
		
		$query 	= " INSERT INTO `#__xius_proximity_geocode` (`{$selectGeocodeCol}`) ( "
				  ." SELECT DISTINCT `{$selectCacheCol}` "
				  ." FROM `#__xius_cache` "
				  ." WHERE ( `{$selectCacheCol}` <> '' ) AND "  
				  ." (`{$selectCacheCol}`) NOT IN ( "
				  ." SELECT `{$selectGeocodeCol}` "
				  ." FROM `#__xius_proximity_geocode` ))";
		
		$db = JFactory::getDBO();
		$db->setQuery( $query );
		return $db->query();		
	}
	
	public static function getInvalidAddress($limit=5)
	{
		if(!$limit)
			return false;
			
		$query		= " SELECT * FROM `#__xius_proximity_geocode` WHERE "
					 ." ( `address` <> ''  AND `valid`='0' ) LIMIT $limit";
		$db = JFactory::getDBO();
		$db->setQuery( $query );
		$address	= $db->loadObjectList();
		return $address;
	}	
	
	public static function updateGeocodesOfInvalidAddress($data)
	{
		$db = JFactory::getDBO();
		foreach( $data as $key=>$value){
			if(is_array($value) &&
					( !array_key_exists('latitude',$value) 
					|| !array_key_exists('longitude',$value)
					|| empty($value['latitude']) 
					|| empty($value['longitude']))					
					) 
					{
						ProximityGoogleapiHelper::deleteInvalidGeocodeAddress($key);
						continue;
					}
				
			$query	= " UPDATE `#__xius_proximity_geocode` SET "
					 ." `latitude` = ".$db->Quote($value['latitude'])." , "
					 ." `longitude` = ".$db->Quote($value['longitude'])." ,"
					 ." `valid` = 1 "
					 ." WHERE `id` = ".$db->Quote($key);
			
			$db->setQuery( $query );
			$db->query();
		}
	}
	
	/*
	 * this function is used to delete the address in geocode
	 * If google does not return the geocode it means there is some mistake in address
	 * so lat and long can not be determine in any case, that why the entry must be removed
	 */
	public static function deleteInvalidGeocodeAddress($key)
	{
		if(!$key)
			return false;

		$db = JFactory::getDBO();	
		$query	= " DELETE FROM `#__xius_proximity_geocode` "
				 ." WHERE `id` = ".$db->Quote($key);
		
		$db->setQuery( $query );
		return $db->query();		
	} 
}
    
