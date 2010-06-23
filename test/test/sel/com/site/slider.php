<?php

class XiusSliderTest extends XiSelTestCase
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
	
	function testXiusSlider()
	{
		$this->loadSql();
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&supplytask=displayresult');
		$this->waitPageLoad();
		$this->windowMaximize();
		$beforeToggle = $this->getElementHeight("//div[@class='xius_ai']");
		$this->click("//div[@class='xius_aiHead']/div");
		$afterToggle=$this->getElementHeight("//div[@class='xius_ai']");
		$this->assertTrue($beforeToggle<$afterToggle);
		//$this->assertTrue(!$this->isElementPresent("id('slide1')/div[1]/div[1]/span]"));	
	}
}
