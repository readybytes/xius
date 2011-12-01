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
		
	}
	
	function testJsMultiprofilePrivacyhtml()
	{   
		$this->changePluginState('js_privacy',false);
	    $this->changePluginState('xipt_privacy',false);
	    JPluginHelper::importPlugin('xius');
		$dispatcher = JDispatcher::getInstance();
		$params	    = array();
		$param 		= new XiusParameter();
		$param->set('jsmultiprofile_privacy','a:1:{i:0;s:1:"0";}');
		$params['params'] = $param;
		$Html 			  = $dispatcher->trigger("onBeforeRenderInfoDisplay",array(&$params));
		$resultHtml 	  =  '<divclass="xiusParameter"><divclass="xiusParameterxiRow"><divclass="xiusParameterxiColxiColKey"><labelid="paramsjsmultiprofile_privacy-lbl"for="paramsjsmultiprofile_privacy"class="hasTip"title="JsMultiprofilePrivacy::Restrictinformationtotheselectedmultiprofiletypesonly">JsMultiprofilePrivacy</label></div><divclass="xiusParameterxiColxiColValue"><selectname="params[jsmultiprofile_privacy][]"id="paramsjsmultiprofile_privacy"multiple="multiple"size="4"><optionvalue="0"selected="selected">All</option><optionvalue="1">mp1</option><optionvalue="2">mp2</option><optionvalue="3">None</option></select></div></div></div>';
		$this->assertEquals($this->cleanWhiteSpaces($Html[0]),$resultHtml,"Html is not matching");
	}
	
}