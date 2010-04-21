<?php

class InstallTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    
    //verify tables setup
    $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function testXIUSInstall()
  {
    // setup default location 
    $this->adminLogin();
    
    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();
      
	// add profiletype-one
    $this->type("install_url", XIUS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
  }
  
  
}
