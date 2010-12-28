<?php

class XiusOnlineUserTest extends XiUnitTestCase
{
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	/**
	 * @dataProvider getConditions
	 */
	function testOnlineUser($post , $result) {
		
		$url = JPATH_ROOT.DS.'test'.DS.'test'.DS.'_data'.DS.'insert.sql';
		$this->_DBO->loadSql($url);
		
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		XiusLibrariesUsersearch::updateCache();
						
		// build the condition and  compare
		$conditions		= XiusLibrariesUsersearch::processSearchData($post);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
		
		// get the user data according to search condition
		
		$data = array(array());
		XiusHelperResults::_getInitialData(&$data);
		XiusHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'], $result);
	}
	
	function getConditions() {
		
		// search online user
		$post1			= array(
								'xiusinfo_11'=>1,'field2'=>'Male','xiusinfo_12'=>1,
								'xiusinfo_41'=>4,'Joomla_4'=>'admin','xiusinfo_42'=>4,		
								'xiusinfo_51'=>5,'onlineuser'=>'online','xiusinfo_52'=>5
								);
		$result1		= 2;
		
		// Search Offline user
		$post2			= array(
								'xiusinfo_11'=>1,'field2'=>'Male','xiusinfo_12'=>1,
								'xiusinfo_41'=>4,'Joomla_4'=>'admin','xiusinfo_42'=>4,		
								'xiusinfo_51'=>5,'onlineuser'=>'offline','xiusinfo_52'=>5
								);
		$result2		= 8;
		
		// default all available
		
		$post3			= array(
								'xiusinfo_51'=>5,'onlineuser'=>'all available','xiusinfo_52'=>5
								);
		$result3		= 9;
		
		return array(array($post1, $result1),
					 array($post2, $result2),
					 array($post3, $result3)
					);
	}
}