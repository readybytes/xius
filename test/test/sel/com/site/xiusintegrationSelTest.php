<?php
class Xiusintegrationtest extends XiSelTestCase{

	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testXiptPluginStatus() {
		$url = dirname(__FILE__).'/sql/'.__CLASS__.'/'.__FUNCTION__.'.start.sql';
		$this->_DBO->loadSql($url);
		
		//Enable Xipt System plugin
		$this->changePluginState('xipt_system', true);
		
		$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
		$this->assertTrue($this->isTextPresent("Fatal error"));
		$this->assertFalse($this->isTextPresent("Gender"));
		$this->assertFalse($this->isTextPresent("Search"));
		$this->assertFalse($this->isTextPresent("Login"));
		
		//Disable Xipt System plugin
		$this->changePluginState('xipt_system', false);
	}
}