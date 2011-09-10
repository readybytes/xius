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
		if(TEST_XIUS_JOOMLA_15)
			$url = JPATH_ROOT.DS.'test'.DS.'test'.DS.'_data'.DS.'15'.DS.'insert.sql';
		else
			$url = JPATH_ROOT.DS.'test'.DS.'test'.DS.'_data'.DS.'16'.DS.'insert.sql';
		$this->_DBO->loadSql($url);
		
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		if (TEST_XIUS_JOOMLA_15)
			$sqlPath = $this->getSqlPath().DS.'15'.DS.__FUNCTION__.".start.sql";
		else
			$sqlPath = $this->getSqlPath().DS.'16'.DS.__FUNCTION__.".start.sql";

		$this->_DBO->loadSql($sqlPath);
		
		XiusLibCron::updateCache();
		JsfieldsBase::setqueryRequired(true);

		// build the condition and  compare
		$conditions		= XiusLibUsersearch::processSearchData($post);
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
		
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