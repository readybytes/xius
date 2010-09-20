<?php

class XiusJoomlaSearchTest extends XiSelTestCase
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
	
	function testJoomlaPluginSearch()
	{
		$this->loadSql();
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->select("//select[@id='Joomlablock']", "label=No");
		// joomla published information will be shown
		$information = array('JoomlaregisterDate'=>'','Joomla_5'=>'name','Joomla_6'=>'username','Joomla_9'=>'123',
							'Joomla_10'=>'email','Joomla_11'=>'register','Joomla_13'=>'','JoomlalastvisitDate'=>'');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		
		$this->fillInfo($information, 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		// match all
		$this->select("xiusjoin", "label=All");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
	}
	
	function testRemoveInJoomlaSearch()
	{
		$this->loadSql();
		$url =  dirname(__FILE__).'/sql/XiusJoomlaSearchTest/testJoomlaPluginSearch.start.sql';
		$this->_DBO->loadSql($url);
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->select("//select[@id='Joomlablock']", "label=No");
		// joomla published information will be shown
		$information = array('JoomlaregisterDate'=>'','Joomla_5'=>'name','Joomla_6'=>'username','Joomla_9'=>'123',
							'Joomla_10'=>'email','Joomla_11'=>'register','Joomla_13'=>'','JoomlalastvisitDate'=>'');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		
		$this->fillInfo($information, 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		// match all
		$this->select("xiusjoin", "label=All");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
		
		// remove id
		$remove = array('email'=>0,'123'=>0,'username'=>56,'name'=>56);
		$this->removeCondition($remove);		
	}
		
	function testAddInfoInJoomlaSearch()
	{
		$this->loadSql();
		$url =  dirname(__FILE__).'/sql/XiusJoomlaSearchTest/testJoomlaPluginSearch.start.sql';
		$this->_DBO->loadSql($url);
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->select("//select[@id='Joomlablock']", "label=No");
		// joomla published information will be shown
		$information = array('JoomlaregisterDate'=>'','Joomla_5'=>'','Joomla_6'=>'name','Joomla_9'=>'66',
							'Joomla_10'=>'email','Joomla_11'=>'register','Joomla_13'=>'','JoomlalastvisitDate'=>'');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		
		$this->fillInfo($information, 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		// match all
		$this->select("xiusjoin", "label=All");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
		
		// add reg date
		/* XITODO : test calander */
	   	$this->type("JoomlaregisterDate", "15-03-2009");
    	$this->click("//img[@class='xius_test_addinfo_4']");
    	$this->waitPageLoad();

    	$element[]= "//img[@class='xius_test_remove_15-3-2009']";
    	$element[]= "//img[@class='xius_test_remove_name']";
    	$element[]= "//img[@class='xius_test_remove_66']";
    	$element[]= "//img[@class='xius_test_remove_email']";
    	$element[]= "//img[@class='xius_test_remove_register']";
    	
    	$this->isSearchElementPresent($element);
    	// match any
		$this->select("xiusjoin", "label=Any");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));		
	}	
}
