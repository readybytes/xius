<?php 

class XiusSortingTest extends XiSelTestCase
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
	
	function testSortingOfUserListing()
	{

		$this->loadSql();
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// insert gender value
		$this->assertTrue($this->isElementPresent("//select[@id='field2']"));
		$this->select("//select[@id='field2']", "label=Male");
			
		$this->click("field17[]");
		$this->click("//input[@name='field17[]' and @value='Checkbox2']");
		$this->click("//input[@name='field17[]' and @value='Checkbox11']");
		
		$information = array('field3'=>'birthday', 'field10'=>'Bihar');
		$this->fillInfo($information, 'OR');
		$this->assertTrue($this->isElementPresent("//span[@id='total_29']"));
		
		$element[] = "//img[@class='xius_test_remove_Checkbox,Checkbox2,Checkbox11']";
		
		// sort according to state
		$this->select("limit", "label=5");
		$this->waitPageLoad();
		$this->select("xiussort", "label=State");
		$this->waitPageLoad();		
		$this->select("xiussortdir", "label=ASC");
		
		$avatar[] = "//img[@id='avatar_89']";
		$avatar[] = "//img[@id='avatar_100']";
		$avatar[] = "//img[@id='avatar_85']";
		$avatar[] = "//img[@id='avatar_75']";
		$avatar[] = "//img[@id='avatar_71']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->select("xiussortdir", "label=DESC");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_108']";
		$avatar[] = "//img[@id='avatar_73']";
		$avatar[] = "//img[@id='avatar_109']";
		$avatar[] = "//img[@id='avatar_112']";
		$avatar[] = "//img[@id='avatar_120']";		
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		// sort according to Birth day date
		$this->select("xiussort", "label=Birthday");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_85']";
		$avatar[] = "//img[@id='avatar_76']";
		$avatar[] = "//img[@id='avatar_119']";
		$avatar[] = "//img[@id='avatar_103']";
		$avatar[] = "//img[@id='avatar_96']";		
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->select("xiussortdir", "label=ASC");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_92']";
		$avatar[] = "//img[@id='avatar_111']";
		$avatar[] = "//img[@id='avatar_120']";
		$avatar[] = "//img[@id='avatar_104']";
		$avatar[] = "//img[@id='avatar_108']";		
		$this->isSearchElementPresent($avatar);
		unset($avatar);
	}
}