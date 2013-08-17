<?php

class XiusGroupMemberSelTest extends XiSelTestCase{
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGroupMember()
	{
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//select[@id='group']"));
		$this->select("group", "label=Lufange-Parinde");
		$this->click("xiussearch");	
		$this->waitPageLoad();
		
		// Check-result
		$this->isElementPresent("//span[@id='total_5']");
		$this->checkUsername(array('admin','username20','username10','username50','username80'));
		
		
		$this->click("xiusSliderImg");
		$this->select("group", "label=Joomla_lover");
		$this->click("//img[@class='xius_test_addinfo_9']");
		$this->waitPageLoad();
//		$this->select("xiusjoin", "label=All");
//		$this->waitPageLoad();
		
		// Check-result
		$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
		$this->checkUsername(array('admin','username20','username10','username50'));
		
		$this->click("xiusSliderImg");
		$this->select("group", "label=RBSL Customer");
		$this->click("//img[@class='xius_test_addinfo_9']");
		$this->waitPageLoad();
		
		// Check-result
		$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
		$this->checkUsername(array('admin','username20'));	
	}
	
	function checkUsername($username)
	{
		foreach($username as $user)
			$this->assertTrue($this->isTextPresent($user));
		
	}
}