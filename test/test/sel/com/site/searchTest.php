<?php

class XiusSearchTest extends XiSelTestCase
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
	
	function testSearchReasultDisable()
	{
		$url=dirname(__FILE__).'/sql/'.__CLASS__.'/testsearchinfodisable.start.sql';
		$this->_DBO->loadSql($url);
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=search');
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent('All searchable information has been disabled by administrator'));  
		
	}
	
	function testXiusSearch()
	{
		$this->loadSql();
		
		// go to search panel
		// condition 1
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Male");
		
		$information = array('field11'=>'Jaipur', 'field10'=>'Rajasthan');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_33']"));
		
		// condition 2
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Female");
		$information = array('field11'=>'Noida', 'field10'=>'Karnataka');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'All');
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
				
	}
	
	function testSearchWithMultipleSameInfo()
	{
		$this->loadSql();
		$url =  dirname(__FILE__).'/sql/XiusSearchTest/testXiusSearch.start.sql';
		$this->_DBO->loadSql($url);
		
		// go to search panel
		// condition 1
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// joomla published information will be shown
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Male");
		
		$information = array('field10'=>'Rajasthan');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		$this->fillInfo($information, 'All');
		$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
		
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Female");
		$this->click("//img[@class='xius_test_addinfo_1']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
    	
    	$element[] = "//img[@class='xius_test_remove_Male']";
    	$element[] = "//img[@class='xius_test_remove_Female']";
    	$element[] = "//img[@class='xius_test_remove_Rajasthan']";
    	$this->isSearchElementPresent($element);
    	
    	// match any condition
    	$this->select("xiusjoin", "label=Any");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_57']"));
		// remove male
		$remove = array('Male'=>33,'Female'=>8,'Rajasthan'=>8);
		$count=1;
		$this->removeCondition($remove,$count);
		
		//remove female
		$remove = array('Female'=>8,'Rajasthan'=>8);
		$count=1;
		$this->removeCondition($remove,$count);
		
		// add same info for state
		$this->type('field10','Rajasthan');
    	$this->click("//img[@class='xius_test_addinfo_20']");
    	$this->waitPageLoad();
		
		$this->assertEquals($this->getXpathCount("//img[contains(@class, 'xius_test_remove_Rajasthan')]"), 1);
	}
	
	function testKeywordSearch()
	{
		$this->changeModuleState('mod_xiusproximity',false);
		$this->loadSql();
		$url =  dirname(__FILE__).'/sql/XiusSearchTest/testXiusSearch.start.sql';
		$this->_DBO->loadSql($url);
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->assertTrue($this->isElementPresent("//select[@id='field12']"));
		// joomla published information will be shown
		$information = array('field11'=>'','Joomla_6'=>'','field3'=>'',
							 'field10'=>'','Keyword_24'=>'Bhilwara');
		$this->isInformationExists($information);
		// call the function the for filling the values of information
		
		$this->fillInfo($information, 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_3']"));
		
		$this->type("Keyword_24", "Jaipur");
    	$this->click("//img[@class='xius_test_addinfo_24']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
    	
    	$this->type("Keyword_24", "Jaipur");
    	$this->click("//img[@class='xius_test_addinfo_24']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
    	
    	$this->assertEquals($this->getXpathCount("//img[contains(@class, 'xius_test_remove_Jaipur')]"), 1);
	}
	
	function testRadioCheckBoxSearch()
	{
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		// search from Radio buttons 
		$this->click("//input[@value='Single']");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_7']"));
    	// compare user listed
    	$avatar[] = "//img[@id='avatar_71']";
		$avatar[] = "//img[@id='avatar_76']";
		$avatar[] = "//img[@id='avatar_91']";
		$avatar[] = "//img[@id='avatar_94']";
		$avatar[] = "//img[@id='avatar_102']";
		$avatar[] = "//img[@id='avatar_108']";
		$avatar[] = "//img[@id='avatar_119']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		// search according to marital status married
		$this->click("//div[@id='xius_Info_Ref10']/div[@class='xius_aiInput']/div/label[2]/input");
		$this->click("//img[@class='xius_test_addinfo_10']");
		$this->waitPageLoad();    
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
		
		$this->click("//img[@class='xius_test_remove_Single']");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_5']"));
    	// compare user listed
    	$avatar[] = "//img[@id='avatar_80']";
		$avatar[] = "//img[@id='avatar_82']";
		$avatar[] = "//img[@id='avatar_100']";
		$avatar[] = "//img[@id='avatar_111']";
		$avatar[] = "//img[@id='avatar_116']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		// serach according to birthday
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->click("//input[@value='Cricket']");
    	$this->select("xiusjoin", "label=Any");
	    $this->click("xiussearch");
    	$this->waitPageLoad();
		
    	$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
    	$avatar[] = "//img[@id='avatar_80']";
		$avatar[] = "//img[@id='avatar_82']";
		$avatar[] = "//img[@id='avatar_102']";		
		$avatar[] = "//img[@id='avatar_116']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		// SEarch according to badminton game
		$this->click("//div[@id='xius_Info_Ref12']/div[@class='xius_aiInput']/div/label[2]/input");
    	$this->click("//img[@class='xius_test_addinfo_12']");    	
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_7']"));
    	$avatar[] = "//img[@id='avatar_91']";
		$avatar[] = "//img[@id='avatar_100']";		
		$avatar[] = "//img[@id='avatar_119']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
						
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->click("//input[@value='Carom']");
    	$this->click("//input[@value='Soccer']");
		$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
    	$avatar[] = "//img[@id='avatar_94']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
	
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();		
		$this->type("//input[@id='field3']", "13-10-1995");
    	$this->click("xiussearch");
		$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
		$avatar[] = "//img[@id='avatar_82']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
				
	}
	
	
	function testProfileTypeSearch()
	{
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->select("field19", "label=Paid Subscriber");
		$this->select("xiusjoin", "label=Any"); // match any
    	$this->click("xiussearch");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_8']"));
    	
    	$element[] = "//img[@class='xius_test_remove_Paid Subscriber']";
    	$this->isSearchElementPresent($element);
		unset($element);
		
    	$this->select("field19", "label=Free Member");
    	$this->click("//img[@class='xius_test_addinfo_9']");
    	$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_13']"));
    	
		$element[] = "//img[@class='xius_test_remove_Paid Subscriber']";
    	$element[] = "//img[@class='xius_test_remove_Free Member']";
    	$this->isSearchElementPresent($element);
		unset($element);
		
    	$this->select("field19", "label=Serious Joomla User");
    	$this->click("//img[@class='xius_test_addinfo_9']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_17']"));
    	
    	$element[] = "//img[@class='xius_test_remove_Paid Subscriber']";
    	$element[] = "//img[@class='xius_test_remove_Free Member']";
    	$element[] = "//img[@class='xius_test_remove_Serious Joomla User']";
    	$this->isSearchElementPresent($element);
		unset($element);    	
	}
	
}
