<?php

class XiusInformationProximityTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSqlFiles()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert17.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/updateCache17.sql');
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
	  
	  for($i=1 ; $i < 11 ; $i++ ){
	  	$this->type("install_url", JOMSOCIAL_ZEND_PLUGIN."/plg_zend_pack_{$i}.zip");
      	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
	  	$this->waitPageLoad();
	  }
	  
	  $this->type("install_url", JOMSOCIAL18_PKG);
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
	  $this->click("//form[@id='installform']/div/div/input");
	  $this->waitForPageToLoad("60000");
	  $this->assertTrue($this->isTextPresent("Jom Social"));
  }
  
  function testProximitySearchByInformation()
  {
  	  $this->loadSqlFiles();

  	  $this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
  	  $this->waitPageLoad();
  	  
  	  // users 400 miles near banglore, with age 15-20 
  	  $this->type("Rangesearch14_min", "15");
  	  $this->type("Rangesearch14_max", "20");
  	  $this->click("//input[@id='Proximityinformation_userForm_option' and @value='addressbox']");
      $this->type("Proximityinformation_userForm_address", "Banglore, India");
      $this->type("Proximityinformation_userForm_dis", "400");
  	  
      $this->click("xiussearch");
      $this->waitPageLoad();
      $this->assertTrue($this->isElementPresent("//span[@id='total_3']"));
      
      // remove previous condition of Banglore
      $this->click("11");
      $this->waitPageLoad();
      $this->assertTrue($this->isElementPresent("//span[@id='total_26']"));
      // now search through google map
      $this->click("//input[@id='Proximityinformation_userForm_option' and @value='googlemap']");
     
	  $this->click("//a[@id='Proximityinformation_userForm_map_button']");		
	  sleep(8);		
      $this->type("xiusAddressEl", "Jaipur, Rajasthan");
      $this->click("find");
      $this->click("sbox-btn-close");
      sleep(2);
      $this->type("Proximityinformation_userForm_dis", "200");
      $this->select("//select[@id='Proximityinformation_userForm_dis_unit']", "label=Kms");
      
      $this->click("//img[@class='xius_test_addinfo_11']");
      $this->waitPageLoad();
      $this->assertTrue($this->isElementPresent("//span[@id='total_3']"));
      
      $this->click("//img[@class='xius_test_remove_From 15 To 20']");
      $this->waitPageLoad();
     
      $this->assertTrue($this->isElementPresent("//span[@id='total_7']"));     
  }
  
  function testProximityByBoth()
  {
 		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert17.sql');
 		// search from proximity information
 		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
  	  	$this->waitPageLoad();
  	  
 		$this->click("//input[@id='Proximityinformation_userForm_option' and @value='googlemap']");
     
	  	$this->click("//a[@id='Proximityinformation_userForm_map_button']");		
	  	sleep(8);		
	    $this->type("xiusAddressEl", "Delhi, India");
	    $this->click("find");
	    $this->click("sbox-btn-close");
	    sleep(2);
	    $this->type("Proximityinformation_userForm_dis", "400");
	    $this->select("//select[@id='Proximityinformation_userForm_dis_unit']", "label=Kms");
	    
	    $this->click("xiussearch");
      	$this->waitPageLoad();
	    $this->assertTrue($this->isElementPresent("//span[@id='total_23']"));
      
	    // search from proximity google api
	    $this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
  	  	$this->waitPageLoad();
  	  
 		$this->click("//input[@id='Proximitygoogle_userForm_option' and @value='googlemap']");
     
	  	$this->click("//a[@id='Proximitygoogle_userForm_map_button']");		
	  	sleep(8);		
	    $this->type("xiusAddressEl", "Delhi, India");
	    $this->click("find");
	    $this->click("sbox-btn-close");
	    sleep(2);
	    $this->type("Proximitygoogle_userForm_dis", "400");
	    $this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
	    
	    $this->click("xiussearch");
      	$this->waitPageLoad();
	    $this->assertTrue($this->isElementPresent("//span[@id='total_22']"));
  }
}
	
