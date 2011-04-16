<?php

class XiusRangesearchUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetAvailableInfoForRangesearch()
	{
		require_once  XIUS_PLUGINS_PATH. DS . 'rangesearch' . DS . 'rangesearch.php';
		$instance = new Rangesearch();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {		
			$requiredInfo = array();			
			$requiredInfo = array( 1 => 'Gender',
								   2 => 'City' , 3 => 'Country' , 4 => 'Register Date',
								   5 => 'Username' , 6 => 'Name' , 7 => 'Checkbox1',
								   8 => 'Birthday' , 9 => 'ID' , 10 => 'E-mail', 11 => 'usertype',
			  					  14 => 'lastvisitDate');
			
			$this->assertEquals($requiredInfo,$info);
		}
	}
	
	function testRangesearch()
	{		
		$url	= JPATH_ROOT.'/test/test/sel/com/site/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$url	= dirname(__FILE__).'/sql/'.__CLASS__.'/testGetAvailableInfoForRangesearch.start.sql';
		$this->_DBO->loadSql($url);
	    
		// IMP : DO NOT UPDATE CACHE, AS Test data is time dependent
 		//require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.'users.php');
 		//$insertedRows = XiusLibUsersearch::updateCache();
		$this->searchUser(array(15,16),11);
		$this->searchUser(array(0,16),46);
		$this->searchUser(array(16,18),14);
		$this->searchUser(array(6),2);
		$this->searchUser(array(),59);
	}
	
	function searchUser($values,$totalUsers)
	{
		$this->resetCachedData();
		// data post
		$post['xiusinfo_251']		= 25;
		if(isset($values[0]))
			$post['Rangesearch8_min']	= $values[0];
		if(isset($values[1]))
			$post['Rangesearch8_max']	= $values[1];
		$post['xiusinfo_252']		= 25;
		
		// build the condition and  compare
		//$startTime 		= $profiler->getmicrotime();
		$conditions		= XiusLibUsersearch::processSearchData($post);
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		
		// get the user data according to search condition
		//require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'results.php');
		
		$data = array(array());
		XiusHelperResults::_getInitialData(&$data);
		XiusHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],$totalUsers);
	}
	
	function testGetUserData()
	{
		//require_once XIUS_PATH_BASE.DS.'factory.php';
		//$instances = array();
		
		XiusFactory::resetStaticData();
		
		// for date type range search
		$instance = XiusFactory::getPluginInstance('',6);
		if($instance)
			$this->assertTrue(true);
		else
			$this->assertFalse(true);
			
		$query		= new XiusQuery();		
		$instance->getUserData($query);
		$strQuery	= $query->__toString();
		$compare    ="SELECTYEAR(LOCALTIME())-YEAR(jsfields3_0.value)-(MONTH(LOCALTIME())"
						."<MONTH(jsfields3_0.value)OR(MONTH(LOCALTIME())=MONTH(jsfields3_0.value)"
						."ANDDAY(LOCALTIME())<DAY(jsfields3_0.value)))ASrangesearch5_0";
		$this->assertEquals($this->cleanWhiteSpaces($strQuery),$compare);
		
		// for integer type range search
		$instance = XiusFactory::getPluginInstance('',8);
		if($instance)
			$this->assertTrue(true);
		else
			$this->assertFalse(true);
			
		$query		= new XiusQuery();		
		$instance->getUserData($query);
		$strQuery	= $query->__toString();
		$compare    ="SELECTjoomlauserid_0.idasrangesearch7_0";
		$this->assertEquals($this->cleanWhiteSpaces($strQuery),$compare);
	}
}
