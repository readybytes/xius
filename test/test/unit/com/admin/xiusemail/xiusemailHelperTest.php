<?php

class XiusemailHelperTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetUserDataFromCache()
	{
		require_once(XIUS_PATH_LIBRARY.DS.'plugins'.DS.'xiusemail'.DS.'helper.php');
		$this->assertFalse(XiusemailHelper::getUserDataFromCache(array(),'joomlaemail_0'));
		
		// email id of userid=62
		$email = XiusemailHelper::getUserDataFromCache(array(62),'joomlaemail_0');
		$this->assertEquals($email[0]->joomlaemail_0,'gaurav.jain028@gmail.com');
		
		// email id of userid=62 and 63
		$email = XiusemailHelper::getUserDataFromCache(array(62,63),'joomlaemail_0');
		$this->assertEquals($email[0]->joomlaemail_0,'gaurav.jain028@gmail.com');
		$this->assertEquals($email[1]->joomlaemail_0,'gaurav@readybytes.in');
		
		// email id of userid=62 and 0
		$email = XiusemailHelper::getUserDataFromCache(array(62,0),'joomlaemail_0');
		$this->assertEquals($email[0]->joomlaemail_0,'gaurav.jain028@gmail.com');
		$this->assertFalse(array_key_exists(1,$email));
		
		// email id of userid=62 and ''
		$email = XiusemailHelper::getUserDataFromCache(array(62,0),'joomlaemail_0');
		$this->assertEquals($email[0]->joomlaemail_0,'gaurav.jain028@gmail.com');
		$this->assertFalse(array_key_exists(1,$email));
	}
	
	function testGetResultedUserId()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testGetUserDataFromCache.start.sql');
		$condition[0]["infoid"]	= 22;
		$condition[0]["value"]	= 'Bhilwara';
		$condition[0]["operator"]= '=';
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$condition,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');		
		$this->assertEquals(XiusemailHelper::getResultedUserId(), array(62,84,90,108,115));
		$this->resetCachedData();
		
		//bhilwara AND gaurav.jain028@gmail.com
		$condition[0]["infoid"]	= 22;
		$condition[0]["value"]	= 'Bhilwara';
		$condition[0]["operator"]= '=';
		
		$condition[1]["infoid"]	= 21;
		$condition[1]["value"]	= 'gaurav.jain028@gmail.com';
		$condition[1]["operator"]= '=';
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$condition,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		$this->assertEquals(XiusemailHelper::getResultedUserId(), array(62));
		$this->resetCachedData();
		
		//bhilwara or gaurav.jain028@gmail.com
		$condition[0]["infoid"]	= 22;
		$condition[0]["value"]	= 'Bhilwara';
		$condition[0]["operator"]= '=';
		
		$condition[1]["infoid"]	= 21;
		$condition[1]["value"]	= 'gaurav.jain028@gmail.com';
		$condition[1]["operator"]= '=';
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$condition,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
		$this->assertEquals(XiusemailHelper::getResultedUserId(), array(62,84,90,108,115));
		$this->resetCachedData();		
	}
	
}
