<?php

class XiusKeywordTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetAvailableInfoForKeyword()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'keyword' . DS . 'keyword.php';
		$instance = new Keyword();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {		
			$requiredInfo = array();			
			$requiredInfo['keywordsearch'] = JText::_('Keyword');			    
			$this->assertEquals($requiredInfo,$info);
		}
	}
	
	function testAddSearchToQueryKeyword()
	{
		$url	= dirname(__FILE__).'/sql/'.__CLASS__.'/testGetAvailableInfoForKeyword.start.sql';
		$this->_DBO->loadSql($url);
		
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.'users.php');
		$insertedRows = XiusControllerUsers::_runCron(array('limitStart'=>0,'limit'=>1000000));
		
		$value		= 'admin';
		$operator	= XIUS_LIKE;
		$join		= 'AND';
		$plgInstance = XiusFactory::getPluginInstanceFromId(24);
		
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'keyword'.DS.'keyword.php');
		$allInfo    = XiusLibrariesInfo::getInfo(array(),'AND',false);
		$strQuery   = $plgInstance->_addSearchToQuery($allInfo,$value);
		$compareQuery= "`jsfields2_0` LIKE '%admin%' OR `jsfields11_0` LIKE '%admin%' OR `jsfields12_0` LIKE '%admin%' OR DATE_FORMAT(`joomlaregisterDate_0`, '%d-%m-%Y') LIKE 'admin' OR `joomlausername_0` LIKE '%admin%' OR `joomlaname_0` LIKE '%admin%' OR `jsfields17_0` LIKE '%admin%' OR `jsfields3_0` LIKE '%admin%' OR `joomlaid_0` LIKE '%admin%' OR `joomlaemail_0` LIKE '%admin%' OR `joomlausertype_0` LIKE '%admin%' OR `joomlablock_0` LIKE '%admin%' OR `joomlagid_0` LIKE '%admin%' OR `joomlalastvisitDate_0` LIKE '%admin%' OR `jsfields4_0` LIKE '%admin%' OR `jsfields5_0` LIKE '%admin%' OR `jsfields7_0` LIKE '%admin%' OR `jsfields8_0` LIKE '%admin%' OR `jsfields9_0` LIKE '%admin%' OR `jsfields10_0` LIKE '%admin%' OR `jsfields13_0` LIKE '%admin%' OR `jsfields15_0` LIKE '%admin%' OR `jsfields16_0` LIKE '%admin%'";
		$this->assertEquals($strQuery, $compareQuery);
	}
	
	function testKeywordsearch()
	{		
		$url	= JPATH_ROOT.'/test/test/sel/com/site/_data';
	    //$this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$url	= dirname(__FILE__).'/sql/'.__CLASS__.'/testGetAvailableInfoForKeyword.start.sql';
		$this->_DBO->loadSql($url);
	    
		$compareCondition[0]["infoid"]	= 24;
		$compareCondition[0]["value"]	= 'admin';
		$compareCondition[0]["operator"]= '=';
		
		// data post
		$post			= array('xiusinfo_241'=>24,'keyword'=>'name','xiusinfo_242'=>24);
		
		// build the condition and  compare
		//$startTime 		= $profiler->getmicrotime();
		$conditions		= XiusLibrariesUsersearch::processSearchData($post);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		
		// get the user data according to search condition
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'views'.DS.'users'.DS.'view.html.php');
		
		$data = array(array());
		XiusViewUsers::_getInitialData(&$data);
		XiusViewUsers::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],58);
	}
}
