<?php

class XiusListTest extends XiSelTestCase
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
		
	function testSaveList()
	{
		//$this->loadSql();		
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
				
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	$this->waitPageLoad();
    	
		$element = "//img[@class='xius_test_remove_Male']";
		$this->click($element);
		$this->waitPageLoad();
		
		$this->select("field2", "label=Female");
   	   	$this->click("//img[@class='xius_test_addinfo_1']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->click("//img[@title='Save This List']");
		
		$this->waitForElement('sbox-window');
		sleep(2);
		
 		$this->assertEquals("1", $this->getValue("name=listid value=1"));
        $this->assertEquals("off", $this->getValue("name=listid value=2"));
        
	    $this->type("xius_list_name", "Female From Afghanistan");
    	$this->type("xius_list_desc", "All Female from afghanistan");
    	$this->click("xiussavenew");
    	
	    sleep(3);
	    $this->waitPageLoad();
        $this->assertTrue($this->isTextPresent("Female From Afghanistan"));
        	
	}
	
	function testListEditing()
	{				
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=2');
    	$this->waitPageLoad();
    	$this->assertFalse($this->isElementPresent("//img[@title='Save']"));
    	
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=2');
    	$this->waitPageLoad();
    	
		$element = "//img[@class='xius_test_remove_16-1-2010']";
		$this->click($element);
		$this->waitPageLoad();
				
		$this->type("field11", "Noida");
   	   	$this->click("//img[@class='xius_test_addinfo_2']");
    	$this->waitPageLoad();

    	$this->type("field11", "Jaipur");
   	   	$this->click("//img[@class='xius_test_addinfo_2']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->click("//img[@title='Save This List']");
		
		$this->waitForElement('sbox-window');
		sleep(2);
		
 		$this->assertEquals("off", $this->getValue("name=listid value=1"));
        $this->assertEquals("2", $this->getValue("name=listid value=2"));
        
	   /* $this->type("xius_list_name", "Users from Noida or Jaipur");
    	$this->type("xius_list_desc", "Users from Noida or Jaipur");*/
    	$this->click("xiussaveexisting");
    	
	    sleep(3);
	    $this->waitPageLoad();
        $this->assertTrue($this->isTextPresent("Register Date is 16-01-2010"));
	}

	function testListByRemovingInfo()
	{
		$this->loadSql();
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	$this->waitPageLoad();
    	
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_Jaipur']"));
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
    	
    	$this->click("//img[@class='xius_test_remove_Male']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_3']"));    	
	}
	
	

	function testListDisplayWithForcesearch()
	{
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=3');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
		
        $this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=4');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));

    	//IMP : Force search is not applicable to admin
    	$this->frontLogin('admin','ssv445');
    	$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=3');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));

	$this->frontLogout();
	}
	
}
