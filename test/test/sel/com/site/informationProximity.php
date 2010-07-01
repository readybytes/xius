<?php

class XiusInformationProximityTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
   /**
   * We will upgrade JomSocial to 1.8
   * @return unknown_type
   */
  function testCommunityInstall()
  {
	   // setup default location 
	   $this->adminLogin();
	    
	   // go to installation
	   $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
	   $this->waitPageLoad("60000");
	      
		// add profiletype-one
	  $this->type("install_url", JOMSOCIAL_PKG);
	  $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
	  $this->waitPageLoad();

	  $this->click("//div[@id='element-box']/div[2]/table/tbody/tr[2]/td/table/tbody/tr[2]/td/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->assertTrue($this->isTextPresent("Jom Social"));
  }
}
	