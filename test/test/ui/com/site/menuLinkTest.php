<?php
class XiusMenuLinkTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function setUp()
  	{
		parent::setUp();
    
    	$filter['sef'] = 0;
    	$filter['sef_suffix'] = 0;
	    $this->updateJoomlaConfig($filter);
  	}
	
	function testMenuLink()
	{
		//test for search link
		$this->open(JOOMLA_LOCATION.'index.php');
		$this->waitPageLoad();
		$this->click("//div[@id='leftcolumn']/div[2]/div/div/div/ul/li[10]/a/span");
		$this->waitPageLoad();
		
		/*
		$option = JRequest::getCmd('option');
		$view	= JRequest::getCmd('view');
		$this->assertTrue($option == 'com_xius');
		$this->assertTrue($view == 'users');
		*/
		
		$this->select("field2", "label=Female");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_63']"));
		$this->assertTrue($this->isTextPresent("Refined By"));	

		// test for display all list
		$this->open(JOOMLA_LOCATION.'index.php');
		$this->waitPageLoad();
		$this->click("//div[@id='leftcolumn']/div[2]/div/div/div/ul/li[11]/a/span");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("All male from 09/05/2009 to 19/05/2009"));
		$this->assertTrue($this->isTextPresent("All female"));
		
		// test for display Particular list
		$this->open(JOOMLA_LOCATION.'index.php');
		$this->waitPageLoad();
		$this->click("//div[@id='leftcolumn']/div[2]/div/div/div/ul/li[12]/a/span");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("All male from 09/05/2009 to 19/05/2009"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Male']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 09-05-2009 To 19-05-2009']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_114']"));
		
		// test clear all
		$this->click("//img[@title='Clear All']");
		$this->waitPageLoad();
		$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_Male']"));
		$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_From 09-05-2009 To 19-05-2009']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_3860']"));
	}
}