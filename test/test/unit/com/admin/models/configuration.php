<?php

class XiusModelsConfigurationTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testSaveNewConfiguration()
	{
		$this->_DBO->addTable('#__xius_config');
		
		$cModel = new XiusModelConfiguration();
		
		$datas[] = array('name' => 'config' , 'params' => array('xiusUserLimit' => 3500 , 'xiusKey' => 'AB2F4' , 'xiusDebugMode' => 1) , 'result' => true);
		$datas[] = array('name' => 'cache' , 'params' => array('cacheStartTime' => 1274243647 , 'cacheEndTime' => 1274243648), 'result' => true);
		
		foreach($datas as $d)
			$this->assertEquals($d['result'],$cModel->save($d['name'],$d['params']));
		
	}
	
	
	function testEditConfiguration()
	{
		$this->_DBO->addTable('#__xius_config');
		
		$cModel = new XiusModelConfiguration();
		
		$datas[] = array('name' => 'config' , 'params' => array('xiusUserLimit' => 1930 , 'xiusKey' => 'AB2F4' , 'xiusDebugMode' => 0) , 'result' => true);
		$datas[] = array('name' => 'cache' , 'params' => array('cacheStartTime' => 1274243747 , 'cacheEndTime' => 1274243748), 'result' => true);
		
		foreach($datas as $d)
			$this->assertEquals($d['result'],$cModel->save($d['name'],$d['params']));
		
	}
	
	
	function testGetOtherParams()
	{
		$cModel = new XiusModelConfiguration();
		
		$datas[] = array('name' => 'config' , 'resultparams' => array('xiusUserLimit' => 1930 , 'xiusKey' => 'AB2F4' , 'xiusDebugMode' => 0));
		$datas[] = array('name' => 'cache' , 'resultparams' => array('cacheStartTime' => 1274243747 , 'cacheEndTime' => 1274243748));
		
		foreach($datas as $d){
			$params = $cModel->getOtherParams($d['name']);
			$pArray = $params->toArray();
			$this->assertEquals($d['resultparams'],$pArray,"Both array are not equal result shoule be ".$d['resultparams']." but we get ".$pArray);
			
			foreach($d['resultparams'] as $k => $v)
				$this->assertEquals($v,$params->get($k),"Value for key $k should be $v but we get ".$params->get($k));
		}		
	}
	
	
	function testGetParams()
	{
		$cModel = new XiusModelConfiguration();
		
		$datas[] = array('resultparams' => array('xiusTemplates' => 'default',
												'integrateJomSocial' => 0,
												'xiusReplaceSearch' => 0,
												'xiusSlideShow' => 'none',
												'xiusLoadJquery' => 0,
												'xiusKey' => 'AB2F4' ,
												'xiusDebugMode' =>0,
												'xiusEnableMatch' => 1,
												'xiusDefaultMatch' => 'AND',
												'xiusListCreator' => 'a:1:{i:0;s:19:"Super Administrator";}','xiusUserLimit' => 1930));
		
		foreach($datas as $d){
			$params = $cModel->getParams();
			$pArray = $params->toArray();
			$this->assertEquals($d['resultparams'],$pArray,"Both array are not equal result shoule be ".$d['resultparams']." but we get ".$pArray);
			
			foreach($d['resultparams'] as $k => $v)
				$this->assertEquals($v,$params->get($k),"Value for key $k should be $v but we get ".$params->get($k));
		}		
	}
	
}
?>
