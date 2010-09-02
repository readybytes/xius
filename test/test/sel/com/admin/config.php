<?php
class XiusConfigAdminSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	// Configuration Testing
	
	function testConfigdb()
	{
		$this->_DBO->addTable('#__xius_config');
		$this->_DBO->filterColumn('#__xius_config','name');
				
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=configuration");
    	$this->waitPageLoad();
		
    	$this->type("//input[@id='xiusparamsxiusKey']", "SSV445");

    	$this->click("//input[@id='xiusparamsxiusDebugMode1']","checked");
    	$this->click("//input[@id='xiusparamsshowSearchMenuTab1']","checked");
    	$this->click("//input[@id='xiusparamsxiusReplaceSearch1']","checked");
    	    	
    	$this->type("//input[@id='xiusparamsxiusProximityDefaultLat']", 25.346251);
    	$this->type("//input[@id='xiusparamsxiusProximityDefaultLong']", 74.636383);
    	
    	$this->click("//td[@id='toolbar-save']/a/span");
    	$this->waitPageLoad();
	}

}