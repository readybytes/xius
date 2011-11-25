<?php
class XiusJsmultiprofilePrivacyTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testmultiprofilePrivacy()
	{
		$this->changePluginState('jsmultiprofile_privacy',true);
		if(TEST_XIUS_JOOMLA_15)
			$url= JPATH_ROOT.'/test/test/unit/com/site/sql/XiusProximityModule/15/enablemodule.start.sql';
	    else
			$url= JPATH_ROOT.'/test/test/unit/com/site/sql/XiusProximityModule/16/enablemodule.start.sql';
			
		$this->_DBO->loadSql($url);
	
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('field10'=>'','field11'=>'','Joomla_9'=>'');
		$this->isInformationExists($info);
		$info1 = array('field2'=>'');
		$this->isInformationExists($info1,'select');
		$this->frontLogout();
		
		$this->frontLogin('user-3','password');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('field10'=>'','field11'=>'');
		$this->isInformationExists($info);
		$this->assertFalse($this->isElementPresent('//input[@id="Joomla_9"]'));
		$this->assertFalse($this->isElementPresent('//select[@id="field2"]'));
		$this->frontLogout();
		
		$this->frontLogin('user-2','password');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent('//input[@id="field11"]'));
		$this->assertTrue($this->isElementPresent('//select[@id="field2"]'));
		$this->assertFalse($this->isElementPresent('//input[@id="Joomla_9"]'));
		$this->assertFalse($this->isElementPresent('//input[@id="field10"]'));
		$this->frontLogout();
		$this->changePluginState('jsmultiprofile_privacy',false);
		
	}
}