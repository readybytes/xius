<?php

class XiusProximityDefaultTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSqlFiles()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testMyLocation.start.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testproximitydefault.start.sql');
	}
	
	function  testMyLocation()
	{
		$this->loadSqlFiles(); 
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad("60000");
		 
		$this->assertTrue($this->isTextPresent("My Location"));
		 
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='googlemap']","checked");
		$this->click("//a[@id='Proximityinformation_userForm_map_button']");
		sleep(12);
		$this->type("//input[@id='xiusAddressEl']", "Jaipur, Rajasthan");
		$this->click("find");
		$this->click("sbox-btn-close");
		sleep(12);
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Show Location"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
	}
	
	function testProximityDefault()
	{
		$this->loadSqlFiles();
		$this->frontLogin();
		$this->assertTrue($this->isTextPresent("Logout"));
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->waitPageLoad();
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		$this->click("xiusSliderImg");
		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='mylocation']","checked");
		$this->click("//img[@class='xius_test_addinfo_11']");
    	$this->waitForPageToLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
    	$this->click("//input[@value='Logout']");
    	$this->waitPageLoad();
      }
}