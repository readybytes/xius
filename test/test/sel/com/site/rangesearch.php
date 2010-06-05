<?php

class XiusRangesearchTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
		
	function testXiusRangesearch()
	{	
		// go to search panel
		// condition 1
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// age		
		$information = array('Rangesearch8_min'=>'16', 'Rangesearch8_max'=>'18');
		$this->fillRangeInfo($information, 'OR');
		$this->assertTrue($this->isElementPresent("//span[@id='total_15']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 16 To 18']"));
		// registration
		$information = array('Rangesearch4_min'=>'2', 'Rangesearch4_max'=>'8');
		$this->fillRangeInfo($information, 'OR');
		$this->assertTrue($this->isElementPresent("//span[@id='total_27']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 2 To 8']"));
		// age and registration
		$information = array('Rangesearch8_min'=>'0', 'Rangesearch8_max'=>'14','Rangesearch4_min'=>'5', 'Rangesearch4_max'=>'9');
		$this->fillRangeInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 0 To 14']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 5 To 9']"));
					
		$information = array('Rangesearch2_min'=>'sdfasd', 'Rangesearch2_max'=>'14');
		$this->fillRangeInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_From sdfasd To 14']"));
		
		$information = array('Rangesearch2_min'=>'0', 'Rangesearch2_max'=>'14');
		$this->fillRangeInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 0 To 14']"));
		
		$information = array('Rangesearch2_min'=>'1', 'Rangesearch2_max'=>'14');
		$this->fillRangeInfo($information, 'AND');
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 1 To 14']"));
				
	}
	

	function testRangeSearchThroughResultPanel()
	{
		$url =  dirname(__FILE__).'/sql/XiusRangesearchTest/testXiusRangesearch.start.sql';
		$this->_DBO->loadSql($url);
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->click("xiussearch");
	    $this->waitPageLoad();
	    $this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
	    
	    $this->type('Rangesearch8_min','12');
	    $this->type('Rangesearch8_max','14');	    
    	$this->click("//img[@class='xius_test_addinfo_25']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_20']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 12 To 14']"));

    	$this->type('Rangesearch8_min','12');
	    $this->type('Rangesearch8_max','14');	    
    	$this->click("//img[@class='xius_test_addinfo_25']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_20']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 12 To 14']"));
	    // after adding same condition only one should be exists
    	$this->assertEquals($this->getXpathCount("//img[contains(@class, 'xius_test_remove_From 12 To 14')]"), 1);
	
    	$this->type('Rangesearch8_min','12');
	    $this->type('Rangesearch8_max','13');	    
    	$this->click("//img[@class='xius_test_addinfo_25']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_14']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 12 To 13']"));
	    
    	$this->type('Rangesearch4_min','2');
	    $this->type('Rangesearch4_max','8');	    
    	$this->click("//img[@class='xius_test_addinfo_26']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 2 To 8']"));
	    
		$this->click("//img[@title='Clear All Applied Info']");
    	$this->waitPageLoad();
    	
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_From 2 To 8']"));
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_From 12 To 13']"));
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_From 12 To 14']"));
    	
    	$this->type('Rangesearch4_min','');
	    $this->type('Rangesearch4_max','6');	    
    	$this->click("//img[@class='xius_test_addinfo_26']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_56']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 0 To 6']"));

    	$this->type('Rangesearch8_min','13');
	    $this->type('Rangesearch8_max','');	    
    	$this->click("//img[@class='xius_test_addinfo_25']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_26']"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_From 0 To 13']"));
	    
	}
	
	function testRangesearchSorting()
	{
		$url =  dirname(__FILE__).'/sql/XiusRangesearchTest/testXiusRangesearch.start.sql';
		$this->_DBO->loadSql($url);
				
		$information = array('Rangesearch8_min'=>'16', 'Rangesearch8_max'=>'18');
		$this->fillRangeInfo($information, 'OR');
		$this->assertTrue($this->isElementPresent("//span[@id='total_15']"));
		
		if($this->getSelectedLabel("limit") != '5'){
			$this->select("limit", "label=5");
			$this->waitPageLoad();	
		}
		
		if($this->getSelectedLabel("xiussort") != 'Age'){
			$this->select("xiussort", "label=Age");
			$this->waitPageLoad();	
		}
		
		if($this->getSelectedLabel("xiussortdir") != 'ASC'){
			$this->select("xiussortdir", "label=ASC");
			$this->waitPageLoad();
		}		
		
		$avatar[] = "//img[@id='avatar_66']";
		$avatar[] = "//img[@id='avatar_68']";
		$avatar[] = "//img[@id='avatar_71']";
		$avatar[] = "//img[@id='avatar_77']";
		$avatar[] = "//img[@id='avatar_84']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
	
		$this->select("xiussortdir", "label=DESC");
		$this->waitPageLoad();
		
		$avatar[] = "//img[@id='avatar_65']";
		$avatar[] = "//img[@id='avatar_69']";
		$avatar[] = "//img[@id='avatar_98']";
		$avatar[] = "//img[@id='avatar_102']";
		$avatar[] = "//img[@id='avatar_67']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		
	}
	
	function fillRangeInfo($information, $join)
	{
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		$this->isInformationExists($information);
		
		foreach( $information as $key=>$val)
			$this->type('//input[@id="'.$key.'"]', "$val"); 
			
	    $this->click("//input[@name='xius_join' and @value='$join']"); // match any
	    $this->click("xiussearch");
	    $this->waitPageLoad();			
	}
}