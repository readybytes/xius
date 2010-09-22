<?php

//$requirPath = JPATH_ROOT.DS.'test'.DS.'system';
//require_once $requirPath.DS.'selUtils.php';

class XiusTemplatesTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	//testing for template selecting or not
	function testSelectTemplateTest()
	{
		$this->_DBO->addTable('#__xius_config');
				
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageload();
		$this->select("field2", "label=Male");
		$this->select("xiusjoin", "label=Any");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("FILTERED BY "));
		$this->assertTrue($this->isTextPresent("FILTER BY "));
		$this->assertFalse($this->isElementPresent("//img[@title='Offline']"));
				
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=configuration");
    	$this->waitPageLoad();
		$this->select("xiusparams[xiusTemplates]", "label=default");
    	$this->click("link=Save");
   		$this->waitPageLoad();
   		
   		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageload();
		$this->select("field2", "label=Male");
		$this->select("xiusjoin", "label=Any");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Refined By"));
		$this->assertTrue($this->isTextPresent("Refine Results"));
	}
}