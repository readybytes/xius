<?php

class XiusForceSearchSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	//Test case for FORCESEARCH WITH KEYWORD
	function testForceSearchWithKeyword()
	{	
		// GoTO search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
				
		$this->type("//input[@id='field11']", "Bhilwara");
		$this->type("//input[@id='field10']", "Rajasthan");

		
		$this->click("xiussearch");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
    	
    	$this->select("xiusjoin", "label=Match Any");
       	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
    	
    	$element="//img[@class='xius_test_remove_Bhilwara']";
    	$this->click($element);
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
    	
    	$this->click("xiusSliderImg");
    	$this->type("//input[@id='field10']", "Gujrat");
    	$this->click("//img[@class='xius_test_addinfo_7']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
    	
    	$element= "//img[@class='xius_test_remove_Rajasthan']";
    	    	
    	$this->click($element);
	    $this->waitPageLoad();
	    
    	$this->assertFalse($this->isElementPresent($element));
    	    	
      	$element="//img[@class='xius_test_remove_Gujrat']";
    	$this->click($element);
    	$this->waitPageLoad();
    	$this->assertFalse($this->isElementPresent($element));
     	
    	$this->click("xiusSliderImg");
		$this->click("//input[@ id='Proximitygoogle_userForm_option']", "googlemap");
		$this->click("Proximitygoogle_userForm_map_button");
		sleep(12);
		$this->type("//input[@id='xiusAddressEl']", "Pune,Maharashtra,India");
		$this->click("find");
		
		$this->click("sbox-btn-close");
		sleep(2);
	    $this->type("//input[@id='Proximitygoogle_userForm_dis']", "500");
	    $this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
	    
		$this->click("//img[@class='xius_test_addinfo_8']");
    	$this->waitPageLoad();
    	//$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
	}
	
	
	//Test case for FORCE SEARCH WITH PROFILETYPE
	 function testForceSearchWithProfiletype()
		{	
				
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->select("//select[@name='field20']", "Single");
		$this->select("//select[@id='field2']", "Male");
		$this->click("//input[@name='xius_join' and @value='OR']");
				
		$this->click("xiussearch");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
    	
    	$this->click("xiusSliderImg");
   		$this->select("//select[@id='field19']", "Free Member");
   		$this->click("//img[@class='xius_test_addinfo_9']");
   		$this->waitPageLoad();
   		$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
   		
   		$this->click("//img[@class='xius_test_remove_Single']");
   		$this->waitPageLoad();
   		$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
   		
   		$this->click("xiusSliderImg");
   		$this->select("//select[@id='field2']", "Female");
   		$this->click("//img[@class='xius_test_addinfo_12']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
    }
}
?>