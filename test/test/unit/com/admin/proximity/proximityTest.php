<?php

class XiusProximityTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}	

	function testGetAvailableInfoForProximity()
	{
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once  XIUS_PLUGINS_PATH. DS . 'proximity' . DS . 'proximity.php';
		$instance = new Proximity();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			$requiredInfo['information'] = XiusText::_('BY_INFORMATION');
			$requiredInfo['google'] 	 = XiusText::_('BY_GOOGLE_API');
			
			$this->assertEquals($requiredInfo,$info);
		}
	}
	
	/**
	 * @dataProvider tableMappingProvider
	 */
	function testGetTableMapping($compare)
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');

		$instance = XiusFactory::getPluginInstance('',8);
		$mapping  = $instance->getTableMapping();
		
        $this->assertEquals($mapping, $compare);
	} 
	
	function testIsAllRequirementSatisfy()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
		
		$instance = XiusFactory::getPluginInstance('',8);
		$this->assertTrue($instance->isAllRequirementSatisfy());		
	}
	function testGetUserData()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
						
		$query 					= new XiusQuery();
		$instance 				= XiusFactory::getPluginInstance('',8);
		
		$instance->getUserData($query);
		$strQuery 				= $query->__toString();
		
		$compare		= "SELECTxius_proximity_google.`latitude`asproximity_google_latitude_0,"
						  ."xius_proximity_google.`longitude`asproximity_google_longitude_0,"
						  ."CONCAT_WS(',',jsfields_value.`field_id_11`,jsfields_value.`field_id_10`,"
						  ."jsfields_value.`field_id_12`)asproximity_google_address_0"
						  ."LEFTJOIN`#__xius_proximity_geocode`asxius_proximity_googleON"
						  ."(CONCAT_WS(',',jsfields_value.`field_id_11`,jsfields_value.`field_id_10`,"
						  ."jsfields_value.`field_id_12`)=xius_proximity_google.`address`)";
		
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
		$instance 	= XiusFactory::getPluginInstance('',8);
		// first valid value
		// through address
		$query		= new XiusQuery();
		$value		= array('addressbox','bhilwara,rajasthan,india',24.234,74.5490,200,'Kms');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= "SELECTROUND((3959*acos(cos(0.44237553298691)*
						cos(radians(`proximity_google_latitude_0`))*
						cos(radians(`proximity_google_longitude_0`)
						-(1.3026506251295))+sin(0.44237553298691)*
						sin(radians(`proximity_google_latitude_0`))))
						*1,3)ASxius_proximity_distanceWHEREROUND((3959
						*acos(cos(0.44237553298691)*cos(radians
						(`proximity_google_latitude_0`))*cos(radians
						(`proximity_google_longitude_0`)-(1.3026506251295))
						+sin(0.44237553298691)*sin(radians(`proximity_google_latitude_0`))))*1,3)<=200
						";
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));		
		
		// through google map
		$query		= new XiusQuery();
		$value		= array('googlemap','',24.234,74.5490,200,'Kms');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= "SELECTROUND((3959*acos(cos(0.42296309092831)
						*cos(radians(`proximity_google_latitude_0`))
						*cos(radians(`proximity_google_longitude_0`)
						-(1.3011255040693))+sin(0.42296309092831)
						*sin(radians(`proximity_google_latitude_0`))))
						*1,3)ASxius_proximity_distanceWHEREROUND((3959
						*acos(cos(0.42296309092831)*cos(radians(`proximity_google_latitude_0`))
						*cos(radians(`proximity_google_longitude_0`)
						-(1.3011255040693))+sin(0.42296309092831)
						*sin(radians(`proximity_google_latitude_0`))))*1,3)<=200
						";
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));
				
		// second valid input
		$value		= array('googlemap','',56.234,-104.5490,456,'Miles');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= "SELECTROUND((3959*acos(cos(0.42296309092831)
						*cos(radians(`proximity_google_latitude_0`))
						*cos(radians(`proximity_google_longitude_0`)
						-(1.3011255040693))+sin(0.42296309092831)
						*sin(radians(`proximity_google_latitude_0`))))
						*1,3)ASxius_proximity_distance,ROUND((3959
						*acos(cos(0.98146845156649)*cos(radians
						(`proximity_google_latitude_0`))*
						cos(radians(`proximity_google_longitude_0`)
						-(-1.8247242796676))+sin(0.98146845156649)
						*sin(radians(`proximity_google_latitude_0`))))
						*1,3)ASxius_proximity_distanceWHEREROUND(
						(3959*acos(cos(0.42296309092831)
						*cos(radians(`proximity_google_latitude_0`))*
						cos(radians(`proximity_google_longitude_0`)-
						(1.3011255040693))+sin(0.42296309092831)*
						sin(radians(`proximity_google_latitude_0`))))*
						1,3)<=200ANDROUND((3959*acos(cos(0.98146845156649)
						*cos(radians(`proximity_google_latitude_0`))*
						cos(radians(`proximity_google_longitude_0`)-
						(-1.8247242796676))+sin(0.98146845156649)*
						sin(radians(`proximity_google_latitude_0`))))*1,3)<=456
						";
		
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
