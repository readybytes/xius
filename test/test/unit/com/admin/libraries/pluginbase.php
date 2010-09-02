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
		$instance = new Jsfields();
		
		$info = $instance->getAvailableInfo();
		
		if(!XiusHelpersUtils::isComponentExist('com_community'))
			$this->assertFalse($info);
		else {
		
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
	}
	
	
	/**
	 * @dataProvider pluginClassProvider
	 */
	function testToArray($compareArray,$className)
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className();
		$instanceArray = $instance->toArray();
		
		foreach($compareArray as $k => $v) {
			$this->assertTrue(isset($instanceArray[$k]),"key $k is not set in instanceArray");
		}
	}
	
	
	public static function pluginClassProvider()
	{
		$pluginClass1 = 'Jsfields';
		
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
		//$compareArray1['debugMode']		= 	false;
		
		return array(
			array($compareArray1,$pluginClass1)
		);
	}
	
	
	/**
	 * @dataProvider BindDataProvider
	 */
	function testBind($from,$className)
	{
		if(is_object($from))
			$from = (array) $from;
			
		$this->assertTrue(is_array($from),"from is not an array");
		
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className();
		
		//$ignoreArray = array('debugMode','params','pluginParams');
		
		$this->assertTrue($instance->bind($from),"Bind is not successfull");
		
		$instanceArray = $instance->toArray();
		
		$conditions=array('checkAccFirst' => true , 'checkAccSecond' => false , 'bothEqual' => false);
		$this->compareArray($from,$instanceArray,$conditions);
	}
	
	
	public static function BindDataProvider()
	{
		$pluginClass1 = 'Jsfields';
		
		$bindArray1 = array();
		
		$paramsxmlpath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'params.xml';
		$bindArray1['id']			=	0 ;
		$bindArray1['labelName']	=	'hello';
		//$bindArray1['params']		=	new JParameter('',$paramsxmlpath);
		$bindArray1['key']			=	'';
		//$bindArray1['pluginParams']	=	new JParameter('','');
		$bindArray1['pluginType']	=	$pluginClass1;
		$bindArray1['oredring']		=	0;
		$bindArray1['published']	=	1;
		//$bindArray1['debugMode']	= 	false;
		
		return array(
			array($bindArray1,$pluginClass1)
		);
	}
	
	
	/**
	 * @dataProvider getSatisfy
	 */
	function testIsAllRequirementSatisfy($className,$result=true)
	{
		//require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . strtolower($className) . DS . strtolower($className).'.php';
		$instance = new $className();
		
		if(!XiusHelpersUtils::isComponentExist('com_community'))
			$this->assertFalse($instance->isAllRequirementSatisfy());
		else 
			$this->assertEquals($result,$instance->isAllRequirementSatisfy(),"All Requirement should be satisfy = $result");
	}
	
	public static function getSatisfy()
	{
		$pluginClass1 = 'Jsfields';
		$result = true;
		
		return array(
			array($pluginClass1,$result)
		);
	}
	
	
	/**
	 * @dataProvider searchProvider
	 */
	function testSearchHtml($infoid,$html)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$instance = XiusFactory::getPluginInstanceFromId($infoid);
		$searchHtml = $instance->renderSearchableHtml();
		
		$this->assertEquals($this->cleanWhiteSpaces($html),$this->cleanWhiteSpaces($searchHtml));
	}
	
	
	public static function searchProvider()
	{
		$html1 = '<input type = "hidden" name="xiusinfo_11" id="xiusinfo_11" value="1"/>'
				.'<select id="field2" name="field2" class="jomTips tipRight select required"'
				.' title="Gender::Select gender"><option value=""  selected="selected">'
				.'Select below</option><option value="Male">Male</option>'
				.'<option value="Female">Female</option>'
				.'</select><span id="errfield2msg" style="display:none;">&nbsp;</span>'
				.'<input type = "hidden" name="xiusinfo_12" id="xiusinfo_12" value="1"/>';
		
		$html2 = '<input type = "hidden" name="xiusinfo_21" id="xiusinfo_21" value="2"/>'
				.'<input title="City / Town::City / Town" type="text" value="" id="field11"'
				.' name="field11" maxlength="100" size="40" class="jomTips tipRight inputbox required" />'
				.' <span id="errfield11msg" style="display:none;">&nbsp;</span>'
				.'<input type = "hidden" name="xiusinfo_22" id="xiusinfo_22" value="2"/>';
				
		$html4 = '<inputtype="hidden"name="xiusinfo_41"id="xiusinfo_41"value="4"/>'
				.'<inputtype="text"name="JoomlaregisterDate"id="JoomlaregisterDate"value=""class="inputbox"maxlength="19"/>'
				.'<imgclass="calendar"src="/usr/bin/templates/system/images/calendar.png"alt="calendar"id="JoomlaregisterDate_img"/>'
				.'<inputtype="hidden"name="xiusinfo_42"id="xiusinfo_42"value="4"/>';
		
		$html5 = '<input type = "hidden" name="xiusinfo_51" id="xiusinfo_51" value="5"/>'
				.'<input class="inputbox" type="text" name="Joomla_5" id="Joomla_5" value=""/>'
				.'<input type = "hidden" name="xiusinfo_52" id="xiusinfo_52" value="5"/>';

		$html7 = '<input type = "hidden" name="xiusinfo_71" id="xiusinfo_71" value="7"/>'
				.'<div class="jomTips tipRight" style="display: inline-block;" title="Checkbox1::Checkbox1">'
				.'<label class="lblradio-block">'
				.'<input type="checkbox" name="field17[]" value="Checkbox1" class="checkbox  required validate-custom-checkbox" style="margin: 0 5px 5px 0;" />'
				.'Checkbox1</label><label class="lblradio-block">'
				.'<input type="checkbox" name="field17[]" value="Checkbox11" class="checkbox  required validate-custom-checkbox" style="margin: 0 5px 5px 0;" />'
				.'Checkbox11</label><label class="lblradio-block">'
				.'<input type="checkbox" name="field17[]" value="Checkbox2" class="checkbox  required validate-custom-checkbox" style="margin: 0 5px 5px 0;" />'
				.'Checkbox2</label><label class="lblradio-block">'
				.'<input type="checkbox" name="field17[]" value="Checkbox21" class="checkbox  required validate-custom-checkbox" style="margin: 0 5px 5px 0;" />'
				.'Checkbox21</label><label class="lblradio-block">'
				.'<input type="checkbox" name="field17[]" value="Checkbox" class="checkbox  required validate-custom-checkbox" style="margin: 0 5px 5px 0;" />'
				.'Checkbox</label><span id="errfield17msg" style="display: none;">&nbsp;</span></div>'
				.'<input type = "hidden" name="xiusinfo_72" id="xiusinfo_72" value="7"/>';
		
		$html8 = '<inputtype="hidden"name="xiusinfo_81"id="xiusinfo_81"value="8"/>'
				.'<inputtype="text"name="field3"id="field3"value=""class="inputbox"maxlength="19"/>'
				.'<imgclass="calendar"src="/usr/bin/templates/system/images/calendar.png"alt="calendar"id="field3_img"/>'
				.'<inputtype="hidden"name="xiusinfo_82"id="xiusinfo_82"value="8"/>';
				
		return array(
			array(1,$html1),
			array(2,$html2),
			array(4,$html4),
			array(5,$html5),
			array(7,$html7),
			array(8,$html8),
		);
	}
	
	
	/**
	 * @dataProvider infoProvider
	 */
	function testRemoveExistingInfo($pluginType,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$instance = XiusFactory::getPluginInstance($pluginType);
		
		$totalInfo = $instance->getAvailableInfo();
		$existingInfo = XiusLibrariesInfo::getInfo();
		
		$instance->removeExistingInfo($totalInfo,$existingInfo);
		//$this->assertFalse(array_key_exists($result,$totalInfo),$result." should not be exist in ".$pluginType);
		/*Result values should not be exist in totalinfo*/
		foreach($result as $r)
			$this->assertFalse(array_key_exists($r,$totalInfo),$r." should not be exist in ".$pluginType);
			
	}
	
	
	public static function infoProvider()
	{
		$pluginType1 = 'jsfields';
		
		$result1 = array(2,3,11,12,17);
		
		$pluginType2 = 'joomla';
		
		$result2 = array('name','username','registerDate');
		
		return array(
			array($pluginType1,$result1),
			array($pluginType2,$result2)
		);
	}
	
	
	/**
	 * @dataProvider cacheColumnProvider
	 */
	function testTableMapping($infoid,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$instance = XiusFactory::getPluginInstanceFromId($infoid);
		
		$columns = $instance->getTableMapping();
		
		$this->assertEquals($result,$columns," Both columns are not equal ");
	}
	
	
	public static function cacheColumnProvider()
	{
		$result4	=array();
		$result = new stdClass();
		$result->tableName  		= '`#__users`';
		$result->tableAliasName 	= 'joomlauserregisterDate_0';
		$result->originColumnName  	= 'registerDate';
		$result->cacheColumnName   	= 'joomlaregisterDate_0';
		$result->cacheSqlSpec	 	= 'datetime NOT NULL';
		$result->cacheLabelName		= 'Register Date';
		$result->createCacheColumn	= true;
		$result4[]	=$result;
		
		$result8	=array();
		$result = new stdClass();
		$result->tableName  	   = '`#__community_fields_values`';
		$result->tableAliasName    = 'jsfields3_0';
		$result->originColumnName  = 'value';
		$result->cacheColumnName   = 'jsfields3_0';
		$result->cacheSqlSpec	   = 'datetime NOT NULL';
		$result->cacheLabelName		= 'Birthday';
		$result->createCacheColumn	= true;
		$result8[]	=$result;
		
		$result9	=array();
		$result = new stdClass();
		$result->tableName  		= '`#__users`';
		$result->tableAliasName 	= 'joomlauserid_0';
		$result->originColumnName  	= 'id';
		$result->cacheColumnName   	= 'joomlaid_0';
		$result->cacheSqlSpec	 	= 'int(21) NOT NULL';
		$result->cacheLabelName		= 'UserId';
		$result->createCacheColumn	= true;
		$result9[]	=$result;

		$result10	=array();
		$result = new stdClass();
		$result->tableName  		= '`#__users`';
		$result->tableAliasName 	= 'joomlauserlastvisitDate_0';
		$result->originColumnName   = 'lastvisitDate';
		$result->cacheColumnName    = 'joomlalastvisitDate_0';
		$result->cacheSqlSpec	 	= 'varchar(250) NOT NULL';
		$result->cacheLabelName		= 'Last Visit Date';
		$result->createCacheColumn	= true;
		$result10[]	=$result;
		
		return array(
			array(4,$result4),
			array(8,$result8),
			array(9,$result9),
			array(10,$result10)
		);
	}
	
}
?>
