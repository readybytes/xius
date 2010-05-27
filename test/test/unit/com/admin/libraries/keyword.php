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
		$compareQuery= "`jsfields2` LIKE '%admin%' OR `jsfields11` LIKE '%admin%' OR `jsfields12` LIKE '%admin%' OR DATE_FORMAT(`joomlaregisterDate`, '%d-%m-%Y')LIKE'admin' OR `joomlausername` LIKE '%admin%' OR `joomlaname` LIKE '%admin%' OR `jsfields17` LIKE '%admin%' OR `jsfields3` LIKE '%admin%' OR `joomlaid` LIKE '%admin%' OR `joomlaemail` LIKE '%admin%' OR `joomlausertype` LIKE '%admin%' OR `joomlablock` LIKE '%admin%' OR `joomlagid` LIKE '%admin%' OR `joomlalastvisitDate` LIKE '%admin%' OR `jsfields4` LIKE '%admin%' OR `jsfields5` LIKE '%admin%' OR `jsfields7` LIKE '%admin%' OR `jsfields8` LIKE '%admin%' OR `jsfields9` LIKE '%admin%' OR `jsfields10` LIKE '%admin%' OR `jsfields13` LIKE '%admin%' OR `jsfields15` LIKE '%admin%' OR `jsfields16` LIKE '%admin%'";
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
