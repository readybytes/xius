<?php

class XiusProximityTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSql()
	{
		$jsVersion	= $this->get_js_version();
		$url = dirname(__FILE__).'/_data/insert.sql';
		if(Jstring::stristr($jsVersion,'1.7') || Jstring::stristr($jsVersion,'1.8'))		    	
			$url = dirname(__FILE__).'/_data/insert1.7.sql';
		
		$this->_DBO->loadSql($url);
		$url = dirname(__FILE__).'/_data/updateCache.sql';
		$this->_DBO->loadSql($url);	
	}	

	function testGetAvailableInfoForProximity()
	{
		$this->loadSql(); 
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'proximity' . DS . 'proximity.php';
		$instance = new Proximity();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			$requiredInfo['information'] = JText::_('BY INFORMATION');
			$requiredInfo['google'] 	 = JText::_('BY GOOGLE API');
			
			$this->assertEquals($requiredInfo,$info);
		}
	}
	
	/**
	 * @dataProvider tableMappingProvider
	 */
	function testGetTableMapping($compare)
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');

		$instance = XiusFactory::getPluginInstanceFromId(8);
		$mapping  = $instance->getTableMapping();
		
        $this->assertEquals($mapping, $compare);
	} 
	
	function testIsAllRequirementSatisfy()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
		
		$instance = XiusFactory::getPluginInstanceFromId(8);
		$this->assertTrue($instance->isAllRequirementSatisfy());		
	}
	function testGetUserData()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
						
		$query 					= new XiusQuery();
		$instance 				= XiusFactory::getPluginInstanceFromId(8);
		
		$instance->getUserData($query);
		$strQuery 				= $query->__toString();
		
		$compare		= "SELECTxius_proximity_google.`latitude`asproximity_google_latitude_0,"
						  ."xius_proximity_google.`longitude`asproximity_google_longitude_0,"
						  ."CONCAT_WS(',',jsfields11_0.`value`,jsfields10_0.`value`,jsfields12_0.`value`)"
						  ."asproximity_google_address_0LEFTJOIN`#__xius_proximity_geocode`as"
						  ."xius_proximity_googleON(CONCAT_WS(',',jsfields11_0.`value`,jsfields10_0."
						  ."`value`,jsfields12_0.`value`)=xius_proximity_google.`address`)";
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery),$this->cleanWhiteSpaces($compare));
	}
	
	function testGetArrangedValue()
	{
		$instance 				= new Proximity();		
		$instance->setData('key','0');
		$values					= $instance->_getArrangedValue(array('googlemap','',2.2,3.4,200,'Miles'));
		$compare['address']		= '';
		$compare['latitude']	= 2.2;
		$compare['longitude']	= 3.4;
		$compare['distance']	= 200;
		$compare['dis_unit']	= 'Miles';
		$this->assertEquals($values, $compare);
		
		$values					= $instance->_getArrangedValue(array('addressbox','bhilwara,rajasthan',2.2,200,'Miles',0));
		$compare['address']		= 'bhilwara,rajasthan';
		$compare['latitude']	= 25.346251;
		$compare['longitude']	= 74.636383;
		$compare['distance']	= 'Miles';
		$compare['dis_unit']	= '0';
		$this->assertEquals($values, $compare);
	}
	
	function testValidateValues()
	{
		$instance	= new Proximity();
		$value 		= array('googlemap','',2.2,3.5,200,'Kms');
		$this->assertTrue(is_array($instance->validateValues($value)));
		
		$value 		= array('addressbox','bhilwara',2.2,200,'Kms');
		$this->assertFalse($instance->validateValues($value));
		
		$value 		= array('addressbox','bhilwara',0,3.5,200,'Kms');
		$this->assertTrue(is_array($instance->validateValues($value)));	
	}
	
	function testAddSearchToQuery()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
		$instance 	= XiusFactory::getPluginInstanceFromId(8);
		// first valid value
		// through address
		$query		= new XiusQuery();
		$value		= array('addressbox','bhilwara,rajasthan,india',24.234,74.5490,200,'Kms');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= 'SELECTROUND((3959*acos(cos(0.442375532987)*cos(radians(`proximity_google_latitude_0`))'
					  .'*cos(radians(`proximity_google_longitude_0`)-(1.30265062513))+sin(0.442375532987)'
					  .'*sin(radians(`proximity_google_latitude_0`))))*1,3)ASxius_proximity_distanceHAVING'
					  .'xius_proximity_distance<200';
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));		
		
		// through google map
		$query		= new XiusQuery();
		$value		= array('googlemap','',24.234,74.5490,200,'Kms');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= 'SELECTROUND((3959*acos(cos(0.422963090928)*cos(radians(`proximity_google_latitude_0`))'
					  .'*cos(radians(`proximity_google_longitude_0`)-(1.30112550407))+sin(0.422963090928)'
					  .'*sin(radians(`proximity_google_latitude_0`))))*1,3)ASxius_proximity_distanceHAVING'
					  .'xius_proximity_distance<200';
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));
				
		// second valid input
		$value		= array('googlemap','',56.234,-104.5490,456,'Miles');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= 'SELECTROUND((3959*acos(cos(0.422963090928)*cos(radians(`proximity_google_latitude_0`))'
					  .'*cos(radians(`proximity_google_longitude_0`)-(1.30112550407))+sin(0.422963090928)*'
					  .'sin(radians(`proximity_google_latitude_0`))))*1,3)ASxius_proximity_distance,ROUND('
					  .'(3959*acos(cos(0.981468451566)*cos(radians(`proximity_google_latitude_0`))*cos(radians'
					  .'(`proximity_google_longitude_0`)-(-1.82472427967))+sin(0.981468451566)*sin(radians'
					  .'(`proximity_google_latitude_0`))))*1,3)ASxius_proximity_distanceHAVING'
					  .'xius_proximity_distance<200ANDxius_proximity_distance<456';
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));
		// invalid value, no change in $compare value
		$value		= array('googlmap','',-104.5490,456,'Miles');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));	
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
?>
