<?php

class XiuslistPublishedForAdminTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testDisplayListForAdmin()
	 {
	 	//Enable Xius List Module
	 	$this->changeModuleState('mod_xiuslisting',true);
	 	
	 	//admin login
	 	$this->frontLogin();
	 	$this->assertTrue($this->isTextPresent("some list"));
	 	$this->assertTrue($this->isTextPresent("Private list"));
	 	
	 	// unpublished and Public list
	 	$this->open(JOOMLA_LOCATION.'index.php?option=com_xius&view=list&task=showList&listid=1');
	 	$this->waitPageLoad();
	 	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Female']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_5-3-2009']"));
	 	$this->assertTrue($this->isElementPresent("//span[@id='total_29']"));
				
		// unpublished and Private list
	 	$this->open(JOOMLA_LOCATION.'index.php?option=com_community&view=list&task=showList&usexius=1&listid=2');
	 	$this->waitPageLoad();
	 	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Male']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Afghanistan']"));
	 	$this->assertTrue($this->isElementPresent("//span[@id='total_28']"));
			
	 	$this->changeModuleState('mod_xiuslisting',false);
	 }
}