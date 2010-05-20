<?php
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

class XiusSearchTest extends XiSelTestCase
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
	
	function testXiusSearch()
	{
		$this->loadSql();
		//$url =  dirname(__FILE__).'/sql/XiusJoomlaSearchTest/testJoomlaPluginSearch.start.sql';
		//$this->_DBO->loadSql($url);
		
		// go to search panel
		// condition 1
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Male");
		
		$information = array('field11'=>'Jaipur', 'field10'=>'Rajasthan');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'OR');
		$this->assertTrue($this->isElementPresent("//span[@id='total_33']"));
		
		// condition 2
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Female");
		echo "sads";
		$information = array('field11'=>'Noida', 'field10'=>'Karnataka');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));		
	}
	
	function testSearchWithMultipleSameInfo()
	{
		$this->loadSql();
		$url =  dirname(__FILE__).'/sql/XiusSearchTest/testXiusSearch.start.sql';
		$this->_DBO->loadSql($url);
		
		// go to search panel
		// condition 1
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Male");
		
		$information = array('field10'=>'Rajasthan');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
		
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Female");
		$this->click("//img[@class='xius_test_addinfo_1']");
    	$this->waitPageLoad();
    	
    	$condotions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS);
		print_r(var_export($condotions));
	}
}