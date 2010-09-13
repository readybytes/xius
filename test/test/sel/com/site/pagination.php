<?php 

class XiusPaginationTest extends XiSelTestCase
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
	
	function testPaginationOfUserListing()
	{

		$this->loadSql();
		
		// go to search panel
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->fillInfo(array(), 'Any');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		// sort according to state
		$this->select("limit", "label=5");
		$this->waitPageLoad();
				
		$avatar[] = "//img[@id='avatar_62']";
		$avatar[] = "//img[@id='avatar_63']";
		$avatar[] = "//img[@id='avatar_64']";
		$avatar[] = "//img[@id='avatar_65']";
		$avatar[] = "//img[@id='avatar_66']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("link=4");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_77']";
		$avatar[] = "//img[@id='avatar_78']";
		$avatar[] = "//img[@id='avatar_79']";
		$avatar[] = "//img[@id='avatar_80']";
		$avatar[] = "//img[@id='avatar_81']";		
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		// sort according to Birth day date
		$this->click("link=8");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_97']";
		$avatar[] = "//img[@id='avatar_98']";
		$avatar[] = "//img[@id='avatar_99']";
		$avatar[] = "//img[@id='avatar_100']";
		$avatar[] = "//img[@id='avatar_101']";			
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("link=Next");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_102']";
		$avatar[] = "//img[@id='avatar_103']";
		$avatar[] = "//img[@id='avatar_104']";
		$avatar[] = "//img[@id='avatar_105']";
		$avatar[] = "//img[@id='avatar_106']";		
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("link=End");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_117']";
		$avatar[] = "//img[@id='avatar_118']";
		$avatar[] = "//img[@id='avatar_119']";
		$avatar[] = "//img[@id='avatar_120']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("link=Prev");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_112']";
		$avatar[] = "//img[@id='avatar_113']";
		$avatar[] = "//img[@id='avatar_114']";
		$avatar[] = "//img[@id='avatar_115']";
		$avatar[] = "//img[@id='avatar_116']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);

		$this->click("link=Start");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_62']";
		$avatar[] = "//img[@id='avatar_63']";
		$avatar[] = "//img[@id='avatar_64']";
		$avatar[] = "//img[@id='avatar_65']";
		$avatar[] = "//img[@id='avatar_66']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);	
	}
}
