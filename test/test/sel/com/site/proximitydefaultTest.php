<?php

class XiusProximityDefaultTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSqlFiles()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testproximitydefault.start.sql');
	}
		
	function  testMyLocation()
	{
		$this->loadSqlFiles();
		 
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isTextPresent("My Location"));
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='googlemap']","checked");
		$this->click("//a[@id='Proximityinformation_userForm_map_button']");
		sleep(12);
		$this->type("//input[@id='xiusAddressEl']", "Jaipur, Rajasthan");
		$this->click("find");
		$this->click("sbox-btn-close");
		sleep(2);
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
		$this->assertTrue($this->isTextPresent("Administrator"));
		$this->frontLogout();
	}
	
	function testMyLocationForGuest() {
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		$this->assertNull($this->check("//input[@value='mylocation']"));
		$this->assertNull($this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']"));
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertFalse($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
		$this->assertTrue($this->isTextPresent("administrator"));
		$this->frontLogout();	
	}
}
