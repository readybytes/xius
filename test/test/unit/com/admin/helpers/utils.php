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
		$this->assertEquals($result,isComponentExist($comName,$checkBoth),"component $comName for checkBoth = $checkBoth  should be $result");	
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
		$this->assertEquals($result,getValueFromXiusParams($paramName,$what,$default));
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
}
?>