<?php

class XiusUtilsTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	/**
	 * @dataProvider componentNameProvider
	 */
	function testIsComponentExist($comName,$checkBoth,$result)
	{
		$this->assertEquals($result,XiusHelpersUtils::isComponentExist($comName,$checkBoth),"component $comName for checkBoth = $checkBoth  should be $result");	
	}
	
	
	public static function componentNameProvider()
	{
		return array(
			array('com_contact',true,true),
			array('com_xyz',false,false),
			array('com_user',false,true)
		);
	}
	

	/**
	 * @dataProvider paramProvider
	 */
	function testGetValueFromXiusParams($paramName,$what,$default,$result)
	{
		$this->assertEquals($result,XiusHelpersUtils::getValueFromXiusParams($paramName,$what,$default));
	}
	
	
	public static function paramProvider()
	{
		$params1 = new JParameter('','');
		$what1 = 'what1';
		$default1 = 'default';
		$result1 = 'default';
		return array(
			array($params1,$what1,$default1,$result1)
		);
	}
	
	
	function testGetOtherConfigParams()
	{
		$this->resetCachedData();
		
		$data[] = array('configname' => 'cache','what' => 'cacheStartTime' , 'value' => 1274243747);
		$data[] = array('configname' => 'cache','what' => 'cacheEndTime' , 'value' => 1274243748);
		
		foreach($data as $d){
			$result = XiusHelpersUtils::getOtherConfigParams($d['configname'],$d['what']);
			$this->assertEquals($d['value'],$result,"value for ".$d['what']." should be ".$d['value']." but we get ".$result);
		}
	}
	
	
	function testGetConfigurationParams()
	{
		$this->resetCachedData();
		
		$data[] = array('what' => 'xiusUserLimit' , 'value' => 1930);
		$data[] = array('what' => 'xiusKey' , 'value' => 'AB2F4');
		$data[] = array('what' => 'nxiusDebugMode' , 'value' => 0);
		
		foreach($data as $d){
			$result = XiusHelpersUtils::getConfigurationParams($d['what']);
			$this->assertEquals($d['value'],$result,"value for ".$d['what']." should be ".$d['value']." but we get ".$result);
		}
	}
	
	/**
	 * @dataProvider cronDataProvider
	 */
	function testVerifyCronRunRequired($key,$currentTime,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$this->assertEquals($result,XiusHelpersUtils::verifyCronRunRequired($key,$currentTime));
	}
	

	public static function cronDataProvider()
	{
		return array(
			array(0,1234567,false),
			array('AB2F4',1234567,false),
			array('AB2F4',1274243809,true)
		);
	}
}
?>
