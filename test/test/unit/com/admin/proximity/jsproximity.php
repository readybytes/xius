<?php

	// Test Case of Proximity search with "Match Any" condition 

//XITODO: independent unit testing, remove database dependancy on js 1.8
class XiusJSProximityTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/XiusProximityTest';
	}	
	
	function testProximityWithMatchAny()
		{
			$this->resetCachedData();			
			$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert17.sql');			
 			$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusProximityTest/testProximityByBoth.start.sql');
 			
			//require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
			$data=array(array());
			//$data=array('Proximityinformation_userForm_option'=>'googlemap','Proximityinformation_userForm_address'=>'','Proximityinformation_userForm_lat'=>28.635308,'Proximityinformation_userForm_long'=>77.22496,'Proximityinformation_userForm_dis'=>400,'Proximityinformation_userForm_dis_unit'=>'kms');
			$data=array('0'=>'googlemap','1'=>'','2'=>28.635308,'3'=>77.22496,'4'=>400,'5'=>'kms');
			$post= array('xiusinfo_111'=>11, 'value'=>$data, 'xiusinfo_112'=>11);
			
						
			$conditions		= XiusLibrariesUsersearch::processSearchData($post);
			XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
			XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
			
			//require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'results.php');
		
			$newData = array(array());
			XiusHelperResults::_getInitialData(&$newData);					
			XiusHelperResults::_getTotalUsers(&$newData);		
			$this->assertEquals($newData['total'],23);
			
			$this->resetCachedData();
			
			
			$post			= array('xiusinfo_111'=>11, 'value'=>$data, 'xiusinfo_112'=>11, 'xiusinfo_151'=>15, 'Rangesearch14_min'=>18, 'Rangesearch14_max'=>25, 'xiusinfo_152'=>15);
			$conditions		= XiusLibrariesUsersearch::processSearchData($post);
			XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
			//XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
			
			$newData = array(array());
			XiusHelperResults::_getInitialData(&$newData);					
			XiusHelperResults::_getTotalUsers(&$newData);		
			$this->assertEquals($newData['total'],27);			
		}
}