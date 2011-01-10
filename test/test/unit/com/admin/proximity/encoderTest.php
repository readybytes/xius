<?php

class XiusProximityEncoderTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function requires()
	{	
		require_once(XIUS_PATH_LIBRARY.DS.'plugins'.DS.'proximity'.DS.'encoders'.DS.'encoder.php');
		require_once(XIUS_PATH_LIBRARY.DS.'plugins'.DS.'proximity'.DS.'encoders'.DS.'google.php');
		
	}	

	/**
	 * @dataProvider tableMappingProvider
	 */
	function testGetTableMappingGoogle($compare)
	{	
		$this->requires();
		$instance = XiusFactory::getPluginInstance('',8);
		if($instance)
			$this->assertTrue(true);
		else
			$this->assertFalse(true);
			
		$pde 		= new ProximityGoogleEncoder($instance->getData('pluginParams'));
		$mapping 	= $pde->getTableMapping();
		
        $this->assertEquals($mapping, $compare);		
	}
	
	/**
	 * @dataProvider tableMappingProvider
	 */
	function testGetUserDataGoogle($compare)
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetTableMappingGoogle.start.sql');
		$instance = XiusFactory::getPluginInstance('',8);
		if($instance)
			$this->assertTrue(true);
		else
			$this->assertFalse(true);
			
		$pde 			= new ProximityGoogleEncoder($instance->getData('pluginParams'));
		
		$query 			= new XiusQuery();
		$pde->getUserData($query, $compare);
		$strQuery 		= $query->__toString();
		$compareSql		= "SELECTxius_proximity_google.`latitude`asproximity_google_latitude_0,"
						  ."xius_proximity_google.`longitude`asproximity_google_longitude_0,"
						  ."CONCAT_WS(',',jsfields11_0.`value`,jsfields10_0.`value`,jsfields12_0.`value`)"
						  ."asproximity_google_address_0LEFTJOIN`#__xius_proximity_geocode`as"
						  ."xius_proximity_googleON(CONCAT_WS(',',jsfields11_0.`value`,jsfields10_0."
						  ."`value`,jsfields12_0.`value`)=xius_proximity_google.`address`)";
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $compareSql) ;
	}
	
	function tableMappingProvider()
	{
		$compare 	= array();
		$obj = new stdClass();
		
		$obj->tableName 		= '#__xius_proximity_geocode';
        $obj->tableAliasName 	= 'xius_proximity_google';
        $obj->originColumnName  = 'latitude';
        $obj->cacheColumnName 	= 'proximity_google_latitude_0';
        $obj->cacheSqlSpec	 	= 'float(10,6) DEFAULT NULL'; 
        $obj->cacheLabelName 	= 'Latitude';
        $obj->createCacheColumn	= true;
        $compare[] 				= $obj; 

        $obj = new stdClass();
    	$obj->tableName 		= '#__xius_proximity_geocode';
        $obj->tableAliasName 	= 'xius_proximity_google';
        $obj->originColumnName  = 'longitude';
        $obj->cacheColumnName 	= 'proximity_google_longitude_0';
        $obj->cacheSqlSpec	 	= 'float(10,6) DEFAULT NULL'; 
        $obj->cacheLabelName 	= 'Longitude';
        $obj->createCacheColumn	= true;
        $compare[] 				= $obj; 
        
        $obj	= new stdClass();
		$obj->tableName			= '#__xius_proximity_geocode';
		$obj->tableAliasName 	= "xius_proximity_google";
		$obj->originColumnName	= 'address';
		$obj->cacheColumnName	= 'proximity_google_address_0';
		$obj->cacheSqlSpec		= ' varchar(250) NOT NULL ';
		$obj->cacheLabelName 	= 'Address';
		$obj->createCacheColumn	= true;
		$compare[]				= $obj;
		
		return array(
			array($compare)
			);
	} 
	
	
}