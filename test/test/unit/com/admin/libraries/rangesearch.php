<?php

class XiusRangesearchUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetAvailableInfoForRangesearch()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'rangesearch' . DS . 'rangesearch.php';
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
	    
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.'users.php');
		$insertedRows = XiusLibrariesUsersearch::updateCache();
		
		$this->searchUser(array(15,16),13);
		$this->searchUser(array(0,16),46);
		$this->searchUser(array(16,18),15);
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
		$conditions		= XiusLibrariesUsersearch::processSearchData($post);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		
		// get the user data according to search condition
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'views'.DS.'users'.DS.'view.html.php');
		
		$data = array(array());
		XiusViewUsers::_getInitialData(&$data);
		XiusViewUsers::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],$totalUsers);
	}
}
