<?php

class XiusCronjobSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.'XiusCronjobTest';
	}
	
	function testAutoCronJob() {
		//enable Auto Cache update
		$this->setAutoCronSetup(1);
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		// search without condition
		$this->click('xiussearch');
		$this->waitPageLoad();
		
		$this->_DBO->addTable('#__xius_cache');
	}
}