<?php

class XiusCronJobTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	/**
	 * update cache from front-end
	 */
	function testCronJob()
	 {
		
		$this->changePluginState('xipt_fieldselection', true);
		$this->changePluginState('xipt_privacy', true);
		$mysess = JFactory::getSession();
		$mysess->set('testmode', true);
	 	XiusLibCron::updateCache();
	 	$this->_DBO->addTable('#__xius_cache');
		$this->changePluginState('xipt_fieldselection', false);
		$this->changePluginState('xipt_privacy', false);
		$mysess->set('testmode', false);
	 }
}