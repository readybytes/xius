<?php

class XiusJoinMatchTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testJoinMatch()
	{
		// XITODO : compare config table also
		//$this->_DBO->addTable('#__xius_config');
				
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageload();
		$this->select("field2", "label=Male");
		$this->type("Joomla_5", "name");
		$value = $this->getValue('xiusjoin');
		$this->assertTrue($value === 'OR');
		$this->click("xiussearch");
   		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_58']"));
		
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=configuration");
    	$this->waitPageLoad();
    	$this->click("advanceConfig");
		$this->click("xiusparamsxiusDefaultMatchAND");
    	$this->click("link=Save");
   		$this->waitPageLoad();
   		   		
   		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageload();
		$this->select("field2", "label=Male");
		$this->type("Joomla_5", "name");
		$value = $this->getValue('xiusjoin');
		$this->assertTrue($value === 'AND');
		$this->click("xiussearch");
   		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_28']"));
	}
}