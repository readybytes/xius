<?php

class XiusProximityModule extends XiUnitTestCase {

	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	/**
	 * @dataProvider getConditions
	 */
	function testProximityModule($post, $result, $query , $proximity=null)
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.DS.__FUNCTION__.'.start.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert.sql');
		if(TEST_XIUS_JOOMLA_15){
			$url= dirname(__FILE__).'/sql/'.__CLASS__.'/15/enablemodule.start.sql';
			$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/15/insert.sql');
		}
		if (TEST_XIUS_JOOMLA_16){
			$url= dirname(__FILE__).'/sql/'.__CLASS__.'/16/enablemodule.start.sql';
			$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/16/insert.sql');
		}
		$this->_DBO->loadSql($url);
				
			
		$conditions		= XiusLibUsersearch::processSearchData($post);
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		
		
		// for google Proximity
		if($proximity=='google')
				$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/modulewithgoogle.start.sql');
			
			
		// Change module param
		if($query){
			$db = JFactory::getDBO();
			$db->setQuery($query);
			$db->query();
			//$db->execute($query);
		}
		
		
		$data = array(array());
		XiusHelperResults::_getInitialData(&$data);
		XiusHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'], $result);
		$this->changeModuleState('mod_xiusproximity', false);
	}
	
	function getConditions() {
		
		//Test with keyword and By information (default map value) testing
		$post1			= array('xiusinfo_131'=>13,
								'Keyword_13'=>'user',
								'xiusinfo_132'=>13,
								'xiusinfo_111'=>11,	
								'Proximityinformation_xiusMod45_option'=>'googlemap',	
								'Proximityinformation_xiusMod45_dummy'=>'',	
								'Proximityinformation_xiusMod45_lat'=>	28.635308,	
								'Proximityinformation_xiusMod45_long'=>77.22496,
								'Proximityinformation_xiusMod45_dis'=>	10,
								'Proximityinformation_xiusMod45_dis_unit'=>	'miles',	
								'xiusinfo_112'=>11								
								);
		$result1		 = 4;
		
		
		//  Test with By information, throw google Map
		
		$post2			= array(
								'xiusinfo_111'=>11,	
								'Proximityinformation_xiusMod45_option'=>'googlemap',	
								'Proximityinformation_xiusMod45_dummy'=>'',	
								'Proximityinformation_xiusMod45_lat'=>	21.195,	
								'Proximityinformation_xiusMod45_long'=>72.819444,
								'Proximityinformation_xiusMod45_dis'=>	100,
								'Proximityinformation_xiusMod45_dis_unit'=>	'miles',	
								'xiusinfo_112'=>11								
								);
		$result2		= 3;
		
		// Test with By information, throw My Addressbox
		$post3			= array(
								'xiusinfo_111'=>11,	
								'Proximityinformation_xiusMod45_option'=>'addressbox',	
								'Proximityinformation_xiusMod45_address'=>'Bhilwara',	
								'Proximityinformation_xiusMod45_lat'=>	28.635308,	
								'Proximityinformation_xiusMod45_long'=>77.22496,
								'Proximityinformation_xiusMod45_dis'=>	100,
								'Proximityinformation_xiusMod45_dis_unit'=>	'miles',	
								'xiusinfo_112'=>11								
								);
		$result3		= 8;
				
		$query3 		= "UPDATE #__modules
				  		   SET params ='xius_proximity=information
										xius_proximity_params=address
										xius_distance=miles
										xius_color=blue'
				  			WHERE id =45";
		
		// Test with By information, throw My Location
		$post4			= array('xiusinfo_131'=>13,
								'Keyword_13'=>'name',
								'xiusinfo_132'=>13,
								'xiusinfo_111'=>11,	
								'Proximityinformation_xiusMod45_option'=>'mylocation',	
								'Proximityinformation_xiusMod45_dummy'=>'',	
								'Proximityinformation_xiusMod45_lat'=>	28.635308,	
								'Proximityinformation_xiusMod45_long'=>77.22496,
								'Proximityinformation_xiusMod45_dis'=>	100,
								'Proximityinformation_xiusMod45_dis_unit'=>	'kms',	
								'xiusinfo_112'=>11								
								);
		$result4		= 4;
		
		$query4			= "UPDATE #__modules
				  		   SET params ='xius_proximity=information
				  				 		xius_proximity_params=mylocation
				  				 		xius_distance=kms
				  				 		xius_color=blue'
				  		   WHERE id =45";
		
		// Test with By Google and keyword info
		$post5			= array('xiusinfo_131'=>13,
								'Keyword_13'=>'shyam',
								'xiusinfo_132'=>13,
								'xiusinfo_171'=>17,	
								'Proximitygoogle_xiusMod45_option'=>'addressbox',	
								'Proximitygoogle_xiusMod45_address'=>'Bhilwar',	
								'Proximitygoogle_xiusMod45_lat'=>	28.635308,	
								'Proximitygoogle_xiusMod45_long'=>77.22496,
								'Proximitygoogle_xiusMod45_dis'=>	100,
								'Proximitygoogle_xiusMod45_dis_unit'=>	'miles',	
								'xiusinfo_172'=>17								
								);
		$result5		= 1;
		
		$query5			= "UPDATE #__modules
				  		   SET params ='xius_proximity=google
				  				 		xius_proximity_params=address
				  				 		xius_distance=miles
				  				 		xius_color=blue'
				  		   WHERE id =45";
	
		
		// Test with By Google and keyword info
		$post6			= array(
								'xiusinfo_171'=>17,	
								'Proximitygoogle_xiusMod45_option'=>'googlemap',	
								'Proximitygoogle_xiusMod45_address'=>'Bhilwara,Rajasthan,India',	
								'Proximitygoogle_xiusMod45_lat'=>	25.346251,	
								'Proximitygoogle_xiusMod45_long'=>74.636383,
								'Proximitygoogle_xiusMod45_dis'=>	150,
								'Proximitygoogle_xiusMod45_dis_unit'=>	'kms',	
								'xiusinfo_172'=>17								
								);
		$result6		= 9;
		
		$query6			= "UPDATE #__modules
				  		   SET params ='xius_proximity=google
				  				 		xius_proximity_params=googlemap
				  				 		xius_distance=kms
				  				 		xius_color=gray'
				  		   WHERE id =45";
		
		
		return (array(
					array($post1, $result1, ''),
					array($post2, $result2, ''),
					array($post3, $result3, $query3),
					array($post4, $result4, $query4),
					array($post5, $result5, $query5, 'google'),
					array($post6, $result6, $query6, 'google')
					));
	}
	
}