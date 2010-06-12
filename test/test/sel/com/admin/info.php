<?php

class XiusInfoAdminSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSql()
	{
		$url = dirname(__FILE__).'/_data/insert.sql';
		$this->_DBO->loadSql($url);
		$url = dirname(__FILE__).'/_data/updateCache.sql';
		$this->_DBO->loadSql($url);	
	}
		
	function xtestEditForcesearchInfo()
	{
		//$this->loadSql();		
		//$this->_DBO->addTable('#__xius_info');
		//$this->_DBO->filterColumn('#__xius_info','ordering');
				
		$this->adminLogin();
    	$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xius&view=info");
    	$this->waitPageLoad();
		
	}
	
	
  function xtestAddForceSearch()
  {
    //    setup default location 
    $this->adminLogin();
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_xipt&view=aclrules");
    $this->waitPageLoad();
      
	// add Rule-1
    $this->click("//td[@id='toolbar-new']/a");
    $this->waitPageLoad();
    
    $this->select("//select[@id='acl']", "value=addalbums");
    $this->click("//input[@type='submit']");
    $this->waitPageLoad();
    $this->type("rulename", "Can not Add Album more than 5");
    $this->type("aclparamsaddalbums_limit", "5");
    $this->select("coreparams[core_profiletype]", "label=PROFILETYPE-1");
    $this->click("//td[@id='toolbar-save']/a/span");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Can not Add Album more than 5"));
    $this->_DBO->addTable('#__xipt_aclrules');
    $this->_DBO->filterColumn('#__xipt_aclrules','id');
  }
	
}