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
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'joomla' . DS . 'joomla.php';
		$instance = new Joomla();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			$requiredInfo['id'] 			= JText::_('id');
			$requiredInfo['name'] 			= JText::_('name');
			$requiredInfo['username'] 		= JText::_('username');
			$requiredInfo['email'] 			= JText::_('email');
			$requiredInfo['usertype'] 		= JText::_('usertype');
			$requiredInfo['block'] 			= JText::_('block');
			$requiredInfo['gid'] 			= JText::_('gid');
			$requiredInfo['registerDate'] 	= JText::_('registerDate');
			$requiredInfo['lastvisitDate'] 	= JText::_('lastvisitDate');
		    
			$this->assertEquals($requiredInfo,$info);
		}
	}

	
	
	function testViewSearchHtml()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'joomla' . DS . 'joomla.php';
		$instance = new Joomla();
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'joomla' . DS . 'views' . DS . 'view.html.php';
		$instance->load(5);
		$viewClass = new JoomlaView();
		$searchHtml5 =  $viewClass->searchHtml($instance);
		$result5 = '<input class="inputbox" type="text" name="Joomla_5" id="Joomla_5" value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result5),$this->cleanWhiteSpaces($searchHtml5)); 
		
		$instance->load(4);
		$searchHtml4 =  $viewClass->searchHtml($instance);
		
		$result4 = '<inputtype="text"name="JoomlaregisterDate"id="JoomlaregisterDate"value=""class="inputbox"maxlength="19"/>'
					.'<imgclass="calendar"src="/usr/bin/templates/system/images/calendar.png"alt="calendar"id="JoomlaregisterDate_img"/>';
		$this->assertEquals($this->cleanWhiteSpaces($result4),$this->cleanWhiteSpaces($searchHtml4));
	}
	
}
?>
