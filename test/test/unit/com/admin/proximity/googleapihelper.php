<?php
class XiusProximityGoogleAPITest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testInsertGeocodeRawData()
	{
		$this->_DBO->addTable('#__xius_proximity_geocode');
		$filter['pluginType'] = 'Proximity';
		$filter['key'] = 'google';
		// get the info details of Proximity information
		$info = XiusLibrariesInfo::getInfo($filter);
		$this->assertEquals($info[0]->id,8);
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		ProximityGoogleapiHelper::insertGeocodeRawData($info);
	}
	
	function testGetInvalidAddress()
	{
		$invalidAdd = $this->invalidAddressProvider();
		//$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityGoogleAPITest/testInsertGeocodeRawData.start.sql');
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		// get first two invalid address
		$address = ProximityGoogleapiHelper::getInvalidAddress(2);
		$this->assertEquals($invalidAdd[0],$address[0]);
		$this->assertEquals($invalidAdd[1],$address[1]);
        
        // get first 5 invalid address
		$address = ProximityGoogleapiHelper::getInvalidAddress(5);		
        $this->assertEquals($invalidAdd,$address);	
	}
	
	function testGetGeocodes()
	{
		$address = $this->invalidAddressProvider();
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		// get first two invalid address
		$geocodes = ProximityGoogleapiHelper::getGeocodes($address);
		$compare = $this->geocodeProvider();
		$this->assertEquals($compare,$geocodes);
	}
	
	function testUpdateGeocodesOfInvalidAddress()
	{
		$this->_DBO->addTable('#__xius_proximity_geocode');
		require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
		$geocode = $this->geocodeProvider();
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocode);
		
		$geocode = array();
		$geocode[11]=array('latitude' => 22.725313);
		$geocode[18]=array('latitude','longitude' => 74.6388889);
		ProximityGoogleapiHelper::updateGeocodesOfInvalidAddress($geocode);
	}
	
	public static function invalidAddressProvider()
	{
		$invalidAdd 	= array();
		$obj 			=new stdClass();
        $obj->id 		= 2;
        $obj->address 	=  'Ajmer,Rajasthan,India';
        $obj->latitude 	= ''; 
        $obj->longitude = '';
        $obj->valid 	= 0;
        $invalidAdd[] 	= $obj;

        $obj 			=new stdClass();
        $obj->id 		= 5;
        $obj->address 	=  'Chandigarh,Punjab,India';
        $obj->latitude 	= ''; 
        $obj->longitude = '';
        $obj->valid 	= 0;
        $invalidAdd[]	= $obj;
                
		$obj 			=new stdClass();
        $obj->id 		= 6;
        $obj->address 	= 'Indore,Madhya Pradesh,India';
        $obj->latitude 	= ''; 
        $obj->longitude = '';
        $obj->valid 	= 0;
        $invalidAdd[]	= $obj;
        
        $obj 			=new stdClass();
        $obj->id 		= 8;
        $obj->address 	= 'Shimla,Himachal Pradesh,India';
        $obj->latitude 	= ''; 
        $obj->longitude = '';
        $obj->valid 	= 0;
        $invalidAdd[]	= $obj;
        
        $obj 			=new stdClass();
        $obj->id 		= 9;
        $obj->address 	= 'Pune,Maharashtra,India';
        $obj->latitude 	= ''; 
        $obj->longitude = '';
        $obj->valid 	= 0;
        $invalidAdd[] 	= $obj;
        return $invalidAdd;	
	}
	
	public static function geocodeProvider()
	{
		$geocode[2]=array('latitude' => 26.4538889,'longitude' => 74.6388889);
    	$geocode[5]=array('latitude' => 30.731345,'longitude' => 76.775385);
    	$geocode[6]=array('latitude' => 22.725313,'longitude' => 75.865555);
    	$geocode[8]=array('latitude' => 31.1,'longitude' => 77.17);
    	$geocode[9]=array('latitude' => 18.520469,'longitude' => 73.856621);
    	return $geocode;
	}
}