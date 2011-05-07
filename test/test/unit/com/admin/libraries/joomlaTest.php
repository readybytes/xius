<?php

class XiusJoomlaTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	

	function testGetAvailableInfoForJoomla()
	{
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once  XIUS_PLUGINS_PATH. DS . 'joomla' . DS . 'joomla.php';
		$instance = new Joomla();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			$requiredInfo['id'] 			= 'id';
			$requiredInfo['name'] 			= 'name';
			$requiredInfo['username'] 		= 'username';
			$requiredInfo['email'] 			= 'email';
			$requiredInfo['usertype'] 		= 'usertype';
			$requiredInfo['block'] 			= 'block';
			$requiredInfo['gid'] 			= 'gid';
			$requiredInfo['registerDate'] 	= 'registerDate';
			$requiredInfo['lastvisitDate'] 	= 'lastvisitDate';
		    
			$this->assertEquals($requiredInfo,$info);
		}
	}

	
	
	function testViewSearchHtml()
	{
		require_once  XIUS_PLUGINS_PATH. DS . 'joomla' . DS . 'joomla.php';
		$instance = new Joomla();
		require_once  XIUS_PLUGINS_PATH. DS . 'joomla' . DS . 'views' . DS . 'view.html.php';
		$instance->load(5);
		$viewClass = new JoomlaView();
		$searchHtml5 =  $viewClass->searchHtml($instance);
		$result5 = '<input class="inputbox" type="text" name="Joomla_5" id="Joomla_5" value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result5),$this->cleanWhiteSpaces($searchHtml5)); 
		
		$instance->load(4);
		$searchHtml4 =  $viewClass->searchHtml($instance);
		
		$result4 = '<inputtype="text"name="JoomlaregisterDate"id="JoomlaregisterDate"value=""class="inputbox"maxlength="19"'
				.'/><imgclass="calendar"src="/usr/bin/templates/system/images'
				.'/calendar.png"alt="calendar"id="JoomlaregisterDate_img"/>';

		$this->assertEquals($this->cleanWhiteSpaces($result4),$this->cleanWhiteSpaces($searchHtml4));
	}
	
}
?>
