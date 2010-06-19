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
	{$this->loadSql(); 
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
			
			$requiredInfo[0] 			= JText::_('GEOCODING');
					    
			$this->assertEquals($requiredInfo,$info);
		}
	}

	function testGetTableMapping()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');

		$instance = XiusFactory::getPluginInstanceFromId(6);
		$mapping  = $instance->getTableMapping();
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
	
	function testIsAllRequirementSatisfy()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
		
		$instance = XiusFactory::getPluginInstanceFromId(6);
		$this->assertTrue($instance->isAllRequirementSatisfy());		
	}
	
	function testGetUserData()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
			
		$mapping 	= array();
		$obj = new stdClass();
		
		$obj->tableName 		= '#__xius_proximity';
        $obj->tableAliasName 	= 'xius_proximity_latitude';
        $obj->originColumnName  = 'latitude';
        $obj->cacheColumnName 	= 'latitude_0';
        $obj->cacheSqlSpec	 	= ' Float (10,6) NOT NULL DEFAULT 0 '; 
        $obj->cacheLabelName 	= 'Latitude';
        $mapping[] 				= $obj; 

        $obj = new stdClass();
    	$obj->tableName 		= '#__xius_proximity';
        $obj->tableAliasName 	= 'xius_proximity_longitude';
        $obj->originColumnName  = 'longitude';
        $obj->cacheColumnName 	= 'longitude_0';
        $obj->cacheSqlSpec	 	= ' Float (10,6) NOT NULL DEFAULT 0 '; 
        $obj->cacheLabelName 	= 'Longitude';
        $mapping[] 				= $obj; 
		
		$query 					= new XiusQuery();
		$instance 				= XiusFactory::getPluginInstanceFromId(6);
		
		$instance->getUserData($query);
		$strQuery 				= $query->__toString();
		
		$compare				= 'SELECT  xius_proximity_latitude.`latitude`  '
								  .'as proximity_latitude_0, xius_proximity_longitude.`longitude`  as proximity_longitude_0'
								  .'LEFT JOIN  `#__xius_proximity` as xius_proximity_latitude ON  ( (  '
								  .'xius_proximity_latitude.`city`  = jsfields11_0.`value`  )  AND '
								  .'xius_proximity_latitude.`country` = jsfields12_0.`value`  )' 
								  .'LEFT JOIN  `#__xius_proximity` as xius_proximity_longitude ON  ( ('  
								  .'xius_proximity_longitude.`city`  = jsfields11_0.`value`  )  AND '
								  .'xius_proximity_longitude.`country` = jsfields12_0.`value`  ) ';

		$this->assertEquals($this->cleanWhiteSpaces($strQuery),$this->cleanWhiteSpaces($compare));
	}
	
	function testGetArrangedValue()
	{
		$instance 				= new Proximity();		
		$instance->setData('key','0');
		$values					= $instance->_getArrangedValue(array(2.2,3.4,200,'Miles'));
		$compare['latitude']	= 2.2;
		$compare['longitude']	= 3.4;
		$compare['distance']	= 200;
		$compare['dis_unit']	= 'Miles';
		$this->assertEquals($values, $compare);
		
		$values					= $instance->_getArrangedValue(array(2.2,200,'Miles',0));
		$compare['latitude']	= 2.2;
		$compare['longitude']	= 200;
		$compare['distance']	= 'Miles';
		$compare['dis_unit']	= '0';
		$this->assertEquals($values, $compare);
	}
	
	function testValidateValues()
	{
		$instance	= new Proximity();
		$value 		= array(2.2,3.5,200,'Kms');
		$this->assertTrue($instance->validateValues($value));
		
		$value 		= array(2.2,200,'Kms');
		$this->assertFalse($instance->validateValues($value));
		
		$value 		= array(0,3.5,200,'Kms');
		$this->assertTrue($instance->validateValues($value));	
	}
	
	function testAddSearchToQuery()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testGetAvailableInfoForProximity.start.sql');
		$instance 	= XiusFactory::getPluginInstanceFromId(6);
		$query		= new XiusQuery();
		// first valid value
		$value		= array(24.234,74.5490,200,'Kms');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= 'SELECT  ROUND(( 3959 * acos ( cos(0.422963090928) * cos(radians(`proximity_latitude_0`) )'
						.' * cos( radians(`proximity_longitude_0`) - (1.30112550407))  + sin( 0.422963090928 ) * '
						.'sin( radians(`proximity_latitude_0`) ) ) ) * 1 ,3)   AS xius_proximity_distance'
						.'HAVING  xius_proximity_distance < 200';
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));
		// second valid input
		$value		= array(56.234,-104.5490,456,'Miles');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$compare	= 'SELECTROUND((3959*acos(cos(0.422963090928)*cos(radians(`proximity_latitude_0`))'
						.'*cos(radians(`proximity_longitude_0`)-(1.30112550407))+sin(0.422963090928)*'
						.'sin(radians(`proximity_latitude_0`))))*1,3)ASxius_proximity_distance,'
						.'ROUND((3959*acos(cos(0.981468451566)*cos(radians(`proximity_latitude_0`))'
						.'*cos(radians(`proximity_longitude_0`)-(-1.82472427967))+sin(0.981468451566)'
						.'*sin(radians(`proximity_latitude_0`))))*1,3)ASxius_proximity_distance'
						.'HAVINGxius_proximity_distance<200ANDxius_proximity_distance<456';
		
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));
		// invalid value, no change in $compare value
		$value		= array(-104.5490,456,'Miles');
		$instance->addSearchToQuery(&$query,$value,'=','AND');
		
		$strQuery 	= $query->__toString();
		$this->assertEquals($this->cleanWhiteSpaces($strQuery), $this->cleanWhiteSpaces($compare));	
	}
	
	// add ( for longitude value if they are negative then -- will occur in query
	
}
?>
