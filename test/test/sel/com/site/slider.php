<?php

class XiusSliderTest extends XiSelTestCase
{
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testXiusSlider()
	{
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&supplytask=displayresult');
		$this->waitPageLoad();
		$this->windowMaximize();
		$beforeToggle = $this->getElementHeight("//div[@class='xius_ai']");
		
		$this->click("//a[@id='xius_avail_info_toggle_1']");
		$afterToggle=$this->getElementHeight("//div[@class='xius_ai']");
		
		$this->assertTrue($beforeToggle>$afterToggle);
		//$this->assertTrue(!$this->isElementPresent("id('slide1')/div[1]/div[1]/span]"));	
	}
}
