<?php

class XiusDynamicFilterXiptFields extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testFilterXiptFields()
	{
		$url= dirname(__FILE__).'/sql/'.__CLASS__.'/profilefields.start.sql';
		$this->_DBO->loadSql($url);
		
		//Enable xipt plugins
		$this->changePluginState('xipt_community', true);
		$this->changePluginState('xipt_system', true);
		
		//Enable Dynamic filtering of XiPT-fields Plugin
 		$this->changePluginState('xipt_fieldselection', true);
 		
 		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
    	$this->waitPageLoad();
    	
    	$lableId= array("//select[@id='field2']", "//input[@id='field3']",
    					"//input[@id='field4']", "//textarea[@id='field5']",
    					"//input[@id='field7']", "//input[@id='field8']",
    					"//select[@id='field18']");
    	//Test all info present
    	foreach($lableId as $id)
    		$this->assertTrue($this->isElementPresent($id));
    	
    	$this->select("field18", "label=Free Member");
    	$this->assertFalse($this->isTextPresent("Gender"));
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	
    	$this->select("field18", "label=Paid Subscriber");
    	$this->assertFalse($this->isTextPresent("Gender"));
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	$this->assertFalse($this->isTextPresent("Land phone"));
    	
    	$this->select("field18", "label=Serious Joomla User");
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	$this->assertFalse($this->isTextPresent("Hometown"));
    	$this->assertFalse($this->isTextPresent("About me"));
    	
    	$this->filterByUrl();
    	
    	//Disable xipt plugins
		$this->changePluginState('xipt_community', false);
		$this->changePluginState('xipt_system', false);
		
		//disable Dynamic filtering of XiPT-fields Plugin
 		$this->changePluginState('xipt_fieldselection', false);
	}
	
	function filterByUrl()
	{
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&profileType=50');
    	$this->waitPageLoad();
    	
    	$lableId= array("//select[@id='field2']", "//input[@id='field3']",
    					"//input[@id='field4']", "//textarea[@id='field5']",
    					"//input[@id='field7']", "//input[@id='field8']",
    					"//select[@id='field18']");
    	//Test all info present
    	foreach($lableId as $id)
    		$this->assertTrue($this->isElementPresent($id));
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&profileType=1');
    	$this->waitPageLoad();
    	
    	$this->assertFalse($this->isTextPresent("Gender"));
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	
    	$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&profileType=2');
    	$this->waitPageLoad();
    	$this->assertFalse($this->isTextPresent("Gender"));
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	$this->assertFalse($this->isTextPresent("Land phone"));
    	
    	$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&profileType=3');
    	$this->waitPageLoad();
    	$this->assertFalse($this->isTextPresent("Birthday"));
    	$this->assertFalse($this->isTextPresent("Hometown"));
    	$this->assertFalse($this->isTextPresent("About me"));
	}
}