<?php

class XiusJsIntegrationTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testJsIntegration()
	 {
		// XITODO:: check com_community component install or not			
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community');
		$this->waitPageLoad();
		
		// integrate with JS advance search
		$this->click("//form[@id='cFormSearch']/fieldset/div[2]/a");
		$this->waitPageLoad();
		$this->jsIntegration();
				
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community');
		$this->waitPageLoad();
		//integrate with Jom socail
		$path = XiusRoute::_(JPATH_BASE.'/index.php/jomsocial/users/panel.html?usexius=1');
		$path= str_replace("/var/www", "", $path);
		$this->click("//a[@href='$path']");
		$this->waitPageLoad();
		$this->jsIntegration();
		$this->frontLogout();
	}
	
	function jsIntegration()  
	{
		$this->type("Rangesearch4_min", "16-01-2010");
		$this->type("Rangesearch4_max", "16-01-2010");
		$value = $this->getValue('xiusjoin');
		$this->assertTrue($value === 'AND');
		$this->select("Joomlablock", "label=No");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
		$this->assertTrue($this->isTextPresent("Refined By"));
		
		$this->click("xiusSliderImg");
		$this->type("field11", "bhilwara");
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_addinfo_2']"));
		$this->assertTrue($this->isElementPresent("//img[@id='Rangesearch4_min_img']"));
		$this->assertTrue($this->isElementPresent("//img[@id='Rangesearch4_max_img']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_addinfo_5']"));
	}
}