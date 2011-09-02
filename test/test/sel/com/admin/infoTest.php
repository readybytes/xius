<?php

class XiusInfoAdminSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSql()
	{
		$url = dirname(__FILE__).'/_data/insert.sql';
		$this->_DBO->loadSql($url);
		$url = dirname(__FILE__).'/_data/updateCache.sql';
		$this->_DBO->loadSql($url);	
	}	
	
  	function testAddForceSearch()
 	{	
 	    //Enable xipt_privacy plugin
 	    $this->changePluginState('xipt_system',true);
 	    $this->changePluginState('xipt_community',true);
 		$this->changePluginState('xipt_privacy',true);
 		
	   	$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','ordering');
		$this->_DBO->filterColumn('#__xius_info','id');
				
		$this->adminLogin();
	    $this->open(JOOMLA_LOCATION."administrator/index.php?option=com_xius&view=info");
	    $this->waitPageLoad();
      
		//1. add force search info for date fields
		if(TEST_XIUS_JOOMLA_15)
 	 	   $this->click("//td[@id='toolbar-new']/a");
 	 	else 
 	 	  $this->click("//li[@id='toolbar-new']/a/span");
    	$this->waitPageLoad();
    	
    	$this->select("//select[@id='plugin']", "value=forcesearch");
    	$this->click("infonext");
    	$this->waitPageLoad();
    
    	//Verify existing forse search info value should not be here
//    	$this->assertFalse($this->isElementPresent("//option[@value='1']"));
//		$this->assertFalse($this->isElementPresent("//option[@value='11']"));
//		$this->assertFalse($this->isElementPresent("//option[@value='12']"));
//		$this->assertFalse($this->isElementPresent("//option[@value='14']"));
//		$this->assertFalse($this->isElementPresent("//option[@value='15']"));
//		$this->assertFalse($this->isElementPresent("//option[@value='16']"));
		
		$this->assertTrue($this->isElementPresent("//option[@value='4']"));
    	$this->select("rawdata", "label=Register Date");
    	$this->click("infonext");
    	$this->waitPageLoad();
    	
    	$this->type("labelName", "Register Date Should be 10 Jun 2009");
    	$this->type("//input[@id='JoomlaregisterDate']","10-06-2009");
    	$this->click("paramsisSearchable0");
    	if(TEST_XIUS_JOOMLA_15)
    	  $this->click("//td[@id='toolbar-apply']/a/span");
    	else 
    	  $this->click("//li[@id='toolbar-apply']/a/span");
    	$this->waitPageLoad();
   
    	$this->verifyValue("//input[@id='JoomlaregisterDate']","10-06-2009");
        
    	if(TEST_XIUS_JOOMLA_15)
    	  $this->click("//td[@id='toolbar-save']/a/span");
    	else 
    	  $this->click("//li[@id='toolbar-save']/a/span");
    	
    	$this->waitPageLoad();
    
	    $this->assertTrue($this->isTextPresent("Register Date Should be 10 Jun 2009"));
	    
	    //2. add force search info for checkboxes
	    if(TEST_XIUS_JOOMLA_15)
 	 	  $this->click("//td[@id='toolbar-new']/a");
 	 	else 
 	 	  $this->click("//li[@id='toolbar-new']/a/span");
    	$this->waitPageLoad();
    	
    	$this->select("//select[@id='plugin']", "value=forcesearch");
    	$this->click("infonext");
    	$this->waitPageLoad();
    
    	$this->select("rawdata", "label=Checkbox1");
    	$this->click("infonext");
    	$this->waitPageLoad();
    	
  //  	$this->assertFalse($this->isChecked("//input[@name='field17[]' and @value='Checkbox1']"));
  //  	$this->assertFalse($this->isChecked("//input[@name='field17[]' and @value='Checkbox2']"));
  //  	$this->assertFalse($this->isChecked("//input[@name='field17[]' and @value='Checkbox11']"));
  //  	$this->assertFalse($this->isChecked("//input[@name='field17[]' and @value='Checkbox21']"));
  //  	$this->assertFalse($this->isChecked("//input[@name='field17[]' and @value='Checkbox']"));
    	
    	$this->type("labelName", "Checkbox1 value should be checkbox11 and checkbox");
	    $this->click("published0");
	    if(TEST_XIUS_JOOMLA_15)
	    {
	      $this->click("//input[@name='field17[]' and @value='Checkbox11']");
	      $this->click("//input[@name='field17[]' and @value='Checkbox']");
	    }
	    else 
	    {
	      $this->click("//input[@name='field16[]' and @value='checkbox11']");
	      $this->click("//input[@name='field16[]' and @value='checkbox']");
	    }
	    $this->click("paramsisSearchable0");
	    $this->click("paramsisSortable0");
    	
	    if(TEST_XIUS_JOOMLA_15)
    	  $this->click("//td[@id='toolbar-apply']/a/span");
    	else  
    	  $this->click("//li[@id='toolbar-apply']/a/span");
    	$this->waitPageLoad();
    	
    	 if(TEST_XIUS_JOOMLA_15)
	    {
    	  $this->assertTrue($this->isChecked("//input[@name='field17[]' and @value='Checkbox11']"));
    	  $this->assertTrue($this->isChecked("//input[@name='field17[]' and @value='Checkbox']"));
	    }
 	   else 
	    {
	      $this->assertTrue($this->isChecked("//input[@name='field16[]' and @value='checkbox11']"));
    	  $this->assertTrue($this->isChecked("//input[@name='field16[]' and @value='checkbox']"));
        }
    	if(TEST_XIUS_JOOMLA_15)
    	   $this->click("//td[@id='toolbar-save']/a/span");
    	else 
    	   $this->click("//li[@id='toolbar-save']/a/span");
    	$this->waitPageLoad();
    
	    $this->assertTrue($this->isTextPresent("Checkbox1 value should be checkbox11 and checkbox"));
  
  	}
  

  	function testEditForcesearchInfo()
	{
		$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','ordering');
				
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=info");
    	$this->waitPageLoad();
		
    	//$this->click("span[@id='labelname14']");
	    $this->click("link=Block should be 1");
	    $this->waitPageLoad();
	    $this->type("labelName", "Block should be 0");
	    $this->select("//select[@id='Joomlablock']","label=No");
	    
	    $this->type("//select[@id='Joomlablock']", "0");
	    $this->click("paramsisSortable0");
    	$this->click("paramsisVisible0");
	    $this->type("paramstooltip", "Not Blocked User");
	    if(TEST_XIUS_JOOMLA_15)
	      $this->click("//td[@id='toolbar-apply']/a/span");
	    else 
	      $this->click("//li[@id='toolbar-apply']/a/span");
	      $this->waitPageLoad();
	   
	    if(TEST_XIUS_JOOMLA_15)
	      $this->click("//td[@id='toolbar-cancel']/a/span");
	    else 
	      $this->click("//li[@id='toolbar-cancel']/a/span");
	    $this->waitPageLoad();
	    
	    $this->click("link=All Male");
	    $this->waitPageLoad();
	    $this->type("labelName", "All Female");
	    //$this->assertEquals("CC SELECT BELOWMaleFemale", $this->getText("field2"));
	    
	    $this->verifyValue("//select[@id='field2']",'Male');
    
	    $this->select("field2", "label=Female");
	    $this->click("paramsisExportable0");
	    $this->type("paramstooltip", "Female User");
	    
	    if(TEST_XIUS_JOOMLA_15)
	      $this->click("//td[@id='toolbar-save']/a/span");
	    else
	      $this->click("//li[@id='toolbar-save']/a/span");
	    $this->waitPageLoad();
	    
	    //Edit range search for age group
	    $this->click("link=From 10 to 12 age group");
	    $this->waitPageLoad();
	    $this->type("labelName", "From 0 to 16 age group");
	    $this->verifyValue("//input[@id='Rangesearch8_min']","10");
	    $this->verifyValue("//input[@id='Rangesearch8_max']","12");
	    
	    $this->type("//input[@id='Rangesearch8_min']", "0");
	    $this->type("//input[@id='Rangesearch8_max']", "16");
	    
	    if(TEST_XIUS_JOOMLA_15)
	      $this->click("//td[@id='toolbar-apply']/a/span");
	    else 
	      $this->click("//li[@id='toolbar-apply']/a/span");
	    $this->waitPageLoad();
	    $this->verifyValue("//input[@id='Rangesearch8_min']",'0');
	    $this->verifyValue("//input[@id='Rangesearch8_max']",'16');
	    if(TEST_XIUS_JOOMLA_15)
	      $this->click("//td[@id='toolbar-cancel']/a/span");
	    else
	      $this->click("//li[@id='toolbar-cancel']/a/span");
	    $this->waitPageLoad();
	    
	    //Disable xipt_privacy plugin
 		$this->changePluginState('xipt_privacy',false);
	}
	
}