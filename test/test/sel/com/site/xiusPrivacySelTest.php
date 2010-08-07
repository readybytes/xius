<?php 

class XiusPrivacySelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testPrivacy()
	{
		// for guest
		// searchability
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('input'=>'field10','select'=>'field12','input'=>'field11','input'=>'field3');
		$this->isInformationExists($info);
		
		// visibility and sortability
		$this->click('xiussearch');
		$this->waitPageLoad();		
		$this->assertFalse($this->isTextPresent('Xius Gender'));
		$this->assertFalse($this->isTextPresent('Xius Age'));
		$info = array(21=>false,23=>false,17=>true,18=>true,19=>true,22=>true);
		$this->isOptionPresent($info);
		
		
		// for registered
		$this->frontLogin('username64','password');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('input'=>'field10','select'=>'field12','input'=>'field11','select'=>'field2',
						'input'=>'Rangesearch22_min','input'=>'Rangesearch22_max');
		$this->isInformationExists($info);		
		
		$this->click('xiussearch');
		$this->waitPageLoad();		
		$this->assertFalse($this->isTextPresent('Xius Birthday'));
		$info = array(17=>true,18=>true,19=>true,21=>true,22=>false,23=>true);
		$this->isOptionPresent($info);
		$this->frontLogout();
		
		// for manager
		$this->frontLogin('username65','password');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('input'=>'field10','select'=>'field12','input'=>'field11','input'=>'field3');
		$this->isInformationExists($info);		
		
		$this->click('xiussearch');
		$this->waitPageLoad();		
		$this->assertFalse($this->isTextPresent('Xius Age'));
		$this->assertFalse($this->isTextPresent('Xius Gender'));
		$info = array(17=>true,18=>true,19=>true,21=>false,22=>true,23=>false);
		$this->isOptionPresent($info);
		$this->frontLogout();
		
		
		// for super admin
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$info = array('input'=>'field10','select'=>'field12','input'=>'field11','input'=>'field3',
						'input'=>'Rangesearch22_min','input'=>'Rangesearch22_max','select'=>'field2');
		$this->isInformationExists($info);		
		
		$this->click('xiussearch');
		$this->waitPageLoad();		
		$info = array(17=>true,18=>true,19=>true,21=>true,22=>true,23=>true);
		$this->isOptionPresent($info);
		$this->frontLogout();
	}
	
	function isOptionPresent($information)
	{
		foreach($information as $info=>$val){
			if($val)
				$this->assertTrue($this->isElementPresent("//option[@value=$info]"));
			else
				$this->assertFalse($this->isElementPresent("//option[@value=$info]"));
		}
	}
	
	function isInformationExists($information)
	{
		foreach($information as $info=>$val){
			$element = '//'.$info.'[@id="'.$val.'"]';
			$this->assertTrue($this->isElementPresent($element));
		}	
	}
}