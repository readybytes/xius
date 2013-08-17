<?php

class XiusCronTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testAutoCronJob() 
	{		
		// Test "xiusCronJob" disable
		$this->assertFalse(XiusLibCron::autoCronJob()); 
			
		//enable cache update
		$this->setAutoCronSetup(1);
		
		$cModel = XiusFactory::getInstance ('configuration', 'model');
		// Test Save xiusCronAcessTime
		$this->assertTrue(XiusLibCron::autoCronJob());
		$params = $cModel->getOtherParams('config');
		$this->assertEquals($params->get('xiusCronAcessTime'),time());

	}
}