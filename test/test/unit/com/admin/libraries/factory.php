<?php

class XiusFactoryTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testGetPluginInstance()
	{
		$instance = XiusFactory::getPluginInstance('JsFields');
		//print_r($instance);
		$this->assertEquals("Jsfields",$instance->getMe());
	}
	
	function testGetPluginInstanceFromId()
	{
		$testId = array(1,2,3);
		
		$test = array();
		$test[0]['id'] 					= 1;
		$test[0]['info'] 				= array();
		$test[0]['info']['id'] 			= 1;
		$test[0]['info']['key'] 		= 2;
		$test[0]['info']['labelName'] 	= 'Gender';
		$test[0]['info']['pluginType']	= 'Jsfields';
		
		$test[1]['id'] 					= 2;
		$test[1]['info'] 				= array();
		$test[1]['info']['id']			= 2;
		$test[1]['info']['key']			= 11;
		$test[1]['info']['labelName'] 	= 'City';
		$test[1]['info']['pluginType'] 	= 'Jsfields';
		
		$test[2]['id'] 					= 3;
		$test[2]['info'] 				= array();
		$test[2]['info']['id'] 			= 3;
		$test[2]['info']['key'] 		= 12;
		$test[2]['info']['labelName'] 	= 'Country';
		$test[2]['info']['pluginType'] 	= 'Jsfields';
		
		/*foreach($test as $t) {
			$instance = XiusFactory::getPluginInstanceFromId($t['id']);
			$this->assertEquals($instance->getMe(),"JsFields");
			$property = $instance->getProperties();
			foreach($t['info'] as $k => $v) {
				
				//echo "\nk = $k v = $v p[k] = $property[$k]";
				$this->assertEquals($v,$property[$k]);
			}
		}*/
		
		foreach($test as $t) {
			$instance = XiusFactory::getPluginInstanceFromId($t['id']);
			$this->assertEquals($instance->getMe(),"Jsfields");
			$property = $instance->getProperties();
			$conditions=array('checkAccFirst' => true , 'checkAccSecond' => false , 'bothEqual' => false);
			$this->compareArray($t['info'],$property,$conditions);
		}
		
		foreach($testId as $t){
			$instance = XiusFactory::getPluginInstanceFromId($t);
			$this->assertEquals("Jsfields",$instance->getMe());
		}
			
	}
}
?>