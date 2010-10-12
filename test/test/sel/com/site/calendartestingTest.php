<?php
class XiusCalendarTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
		
	function testCalendarData()
	{	
		//Enable mod_xiussearchpanel  module
 		$this->changeModuleState('mod_xiussearchpanel',true);
		
		$url=dirname(__FILE__).'/sql/'.__CLASS__.'/'.__FUNCTION__.'.start.sql';
		$this->_DBO->loadSql($url);
		// go to search panel
		// check calender display or not
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
				
		//Check on Search Pannel
		$this->click("JoomlaregisterDate_img");	
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate']");
		
		$this->click("field3_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate']");
		
		$this->click("Rangesearch14_min_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate']");
		
		$this->click("Rangesearch14_max_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate']");
				
		$this->calendarTestwithModule();
		$this->calendartestwithJS(); 
				
		//Disable mod_xiussearchpanel Module
 		$this->changeModuleState('mod_xiussearchpanel',false);
 	}
 	
 	function calendarTestwithJS(){
 		// login admin
 		$this->frontLogin();
 		
 		//open Jom Social events
 		$this->open(JOOMLA_LOCATION.'index.php/jomsocial/events/create.html');
		$this->waitPageLoad();
		
		//testing it in jom social
		$this->click("startdate_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='location']");
		$this->click("enddate_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='location']");
				
		$this->calendarTestwithModule();
		$this->frontLogout();
 	}
 	
 	function calendarTestwithModule(){
 		
 		// Testing in Xius Search module
		$this->click("JoomlaregisterDate_xiusMod46_img");	
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate_xiusMod46']");
		
		$this->click("field3_xiusMod46_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate_xiusMod46']");
		
		$this->click("Rangesearch14_xiusMod46_min_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate_xiusMod46']");
		
		$this->click("Rangesearch14_xiusMod46_max_img");
		$this->assertTrue($this->isTextPresent("Select a date "));
		$this->mouseDown("//input[@id='JoomlaregisterDate_xiusMod46']");
	}
}	