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
		//enable Auto Cache update
		$this->setAutoCronSetup(1);
		$this->_DBO->addTable('#__xius_config');
		$this->_DBO->filterColumn('#__xius_config','name');
				
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=configuration");
    	$this->waitPageLoad();
		
    	$this->type("//input[@id='xiusparamsxiusKey']", "SSV445");

    	$this->click("//input[@id='xiusparamsxiusDebugMode1']","checked");
    	$this->click("//input[@id='xiusparamsintegrateJomSocial1']","checked");
    	$this->click("//input[@id='xiusparamsxiusReplaceSearch1']","checked");
    	if (!TEST_XIUS_JOOMLA_15)
    		        $this->addSelection("//select[@name='xiusparams[xiusListCreator][] multiple=']", "label=Administrator"); 	
    	
		if (TEST_XIUS_JOOMLA_15)
    		$this->click("//td[@id='toolbar-save']/a/span");
    	else
    		$this->click("//li[@id='toolbar-save']/a/span");
    	$this->waitPageLoad();
	}

}