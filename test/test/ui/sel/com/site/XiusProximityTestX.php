<?php
class XiusProximityTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSqlFiles()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/updateCache.sql');
		//$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testproximitydefault.start.sql');
	}
	
	function  testAddressNotSet()
	{
		//$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testAddressNotSet.start.sql');
		 
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isTextPresent("My Location"));
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		//$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		$this->frontLogout();
	}
	
	function testMyLocationForUsers()
	{
		$this->loadSqlFiles();
		$this->frontLogin("username64","password");
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isTextPresent("My Location"));
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
		$this->assertTrue($this->isTextPresent("Name64"));
		sleep(12);
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isTextPresent("My Location"));
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->type('Proximityinformation_userForm_dis','100');
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_10']"));
		$this->assertTrue($this->isTextPresent("Name64"));
		$this->frontLogout();
		//$this->waitPageLoad();
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		$this->assertNull($this->check("//input[@value='mylocation']"));
		$this->assertNull($this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']"));
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertFalse($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
	}
	
	function testMyLocationForModule()
	{
		$this->changeModuleState('mod_xiussearchpanel',1);
		// search from module1
	    $this->open(JOOMLA_LOCATION.'/index.php');
  	  	$this->waitPageLoad();
  	  	
  	  	$this->assertNull($this->check("//input[@value='mylocation']"));
		$this->assertNull($this->click("//input[@id='Proximityinformation_xiusMod45_option' and @value='mylocation']"));
		$this->click("//input[@id='xiusMod45Search']");
		$this->waitPageLoad();
		$this->assertFalse($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		$this->frontlogin();
		 $this->open(JOOMLA_LOCATION.'/index.php');
  	  	$this->waitPageLoad();
  	  	
  	  	$this->click("//input[@id='Proximityinformation_xiusMod45_option' and @value='mylocation']");
		$this->click("//input[@id='xiusMod45Search']");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
		$this->assertTrue($this->isTextPresent("administrator"));
		$this->frontLogout();
		$this->changeModuleState('mod_xiussearchpanel',false);
	}
}