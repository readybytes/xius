<?php

class XiusPluginBaseTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testGetAvailableInfo()
	{
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'jsfields' . DS . 'jsfields.php';
		$instance = new JsFields(0);
		
		$info = $instance->getAvailableInfo();
		
		$requiredInfo = array();
		
		$requiredInfo[2] 	= 'Gender';
    	$requiredInfo[3] 	= 'Birthday';
    	$requiredInfo[4] 	= 'Hometown';
	    $requiredInfo[5] 	= 'About me';
	    $requiredInfo[7] 	= 'Mobile phone';
	    $requiredInfo[8] 	= 'Land phone';
	    $requiredInfo[9] 	= 'Address';
	    $requiredInfo[10]	= 'State';
	    $requiredInfo[11] 	= 'City / Town';
	    $requiredInfo[12] 	= 'Country';
	    $requiredInfo[13] 	= 'Website';
	    $requiredInfo[15] 	= 'College / University';
	    $requiredInfo[16] 	= 'Graduation Year';
	    
		$this->assertEquals($requiredInfo,$info);
	}
	
	
	/**
	 * @dataProvider pluginClassProvider
	 */
	function testToArray($compareArray,$className,$debugMode)
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className($debugMode);
		$instanceArray = $instance->toArray();
		
		foreach($compareArray as $k => $v) {
			$this->assertTrue(isset($instanceArray[$k]),"key $k is not set in instanceArray");
		}
	}
	
	
	public function pluginClassProvider()
	{
		$pluginClass1 = 'JsFields';
		$debugMode = false;
		
		$compareArray1 = array();
		
		//$paramsxmlpath = require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'params.xml';
		$compareArray1['id']			=	0 ;
		$compareArray1['labelName']		=	'';
		$compareArray1['params']		=	new JParameter('','');
		$compareArray1['key']			=	'';
		$compareArray1['pluginParams']	=	new JParameter('','');
		$compareArray1['pluginType']	=	$pluginClass1;
		$compareArray1['oredring']		=	0;
		$compareArray1['published']		=	1;
		$compareArray1['debugMode']		= 	false;
		
		return array(
			array($compareArray1,$pluginClass1,$debugMode)
		);
	}
	
	
	/**
	 * @dataProvider BindDataProvider
	 */
	function testBind($from,$className,$debugMode)
	{
		if(is_object($from))
			$from = (array) $from;
			
		$this->assertTrue(is_array($from),"from is not an array");
		
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className($debugMode);
		$this->assertTrue($instance->bind($from),"Bind is not successfull");
		
		$instanceArray = $instance->toArray();
		$this->assertEquals($from,$instanceArray);
	}
	
	
	public function BindDataProvider()
	{
		$pluginClass1 = 'JsFields';
		$debugMode = false;
		
		$bindArray1 = array();
		
		$paramsxmlpath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'params.xml';
		$bindArray1['id']			=	0 ;
		$bindArray1['labelName']	=	'';
		$bindArray1['params']		=	new JParameter('',$paramsxmlpath);
		$bindArray1['key']			=	'';
		$bindArray1['pluginParams']	=	new JParameter('','');
		$bindArray1['pluginType']	=	$pluginClass1;
		$bindArray1['oredring']		=	0;
		$bindArray1['published']		=	1;
		$bindArray1['debugMode']		= 	false;
		
		return array(
			array($bindArray1,$pluginClass1,$debugMode)
		);
	}
	
	
	/**
	 * @dataProvider getSatisfy
	 */
	function testIsAllRequirementSatisfy($className,$debugMode,$result=true)
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className($debugMode);
		$this->assertEquals($result,$instance->isAllRequirementSatisfy(),"All Requirement should be satisfy = $result");
	}
	
	public function getSatisfy()
	{
		$pluginClass1 = 'JsFields';
		$debugMode1 = false;
		$result = true;
		
		return array(
			array($pluginClass1,$debugMode1,$result)
		);
	}
	
}
?>