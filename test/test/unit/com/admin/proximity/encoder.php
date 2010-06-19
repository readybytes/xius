<?php

class XiusProximityEncoderTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSql()
	{
		$url = dirname(__FILE__).'/_data/insert.sql';
		$this->_DBO->loadSql($url);
		$url = dirname(__FILE__).'/_data/updateCache.sql';
		$this->_DBO->loadSql($url);	
		
		require_once(XIUS_PATH_LIBRARY.DS.'plugins'.DS.'proximity'.DS.'encoders'.DS.'encoder.php');
		require_once(XIUS_PATH_LIBRARY.DS.'plugins'.DS.'proximity'.DS.'encoders'.DS.'database.php');
		
	}	

	function testGetTableMappingDatabase()
	{
		$this->loadSql();
		
		$instance = XiusFactory::getPluginInstanceFromId(6);
		
		$pde 		= new ProximityDatabaseEncoder($instance->getData('pluginParams'));
		$mapping 	= $pde->getTableMapping();
		$compare 	= array();
		$obj = new stdClass();
		
		$obj->tableName 		= '#__xius_proximity';
        $obj->tableAliasName 	= 'xius_proximity_latitude';
        $obj->originColumnName  = 'latitude';
        $obj->cacheColumnName 	= 'proximity_latitude_0';
        $obj->cacheSqlSpec	 	= ' Float (10,6) NOT NULL DEFAULT 0 '; 
        $obj->cacheLabelName 	= 'Latitude';
        $obj->createCacheColumn	= true;
        $compare[] 				= $obj; 

        $obj = new stdClass();
    	$obj->tableName 		= '#__xius_proximity';
        $obj->tableAliasName 	= 'xius_proximity_longitude';
        $obj->originColumnName  = 'longitude';
        $obj->cacheColumnName 	= 'proximity_longitude_0';
        $obj->cacheSqlSpec	 	= ' Float (10,6) NOT NULL DEFAULT 0 '; 
        $obj->cacheLabelName 	= 'Longitude';
        $obj->createCacheColumn	= true;
        $compare[] 				= $obj; 

        $this->assertEquals($mapping, $compare);		
	}
	
	function testGetDatabaseCloumnNameForDatabase()
	{
		$this->loadSql();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityEncoderTest/testGetTableMappingDatabase.start.sql');		
		$instance = XiusFactory::getPluginInstanceFromId(6);		
		$pde 		= new ProximityDatabaseEncoder($instance->getData('pluginParams'));
		$columns 	= $pde->GetDatabaseCloumnName();
		
		$compare['city'] = 'city';
    	$compare['zipcode'] = 'zipcode';    
    	$compare['country'] = 'country';
    	$compare['state'] = 'state';
		
		$this->assertEquals($columns,$compare);		
	}
	
	
}