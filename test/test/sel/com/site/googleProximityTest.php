<?php

class XiusGoogleProximityTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function loadSqlFiles()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/insert.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/_proximityData/updateCache.sql');
	}
	
	function testSearchByGoogleAPI()
	{
		$this->loadSqlFiles();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// search users from bhilwara
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");		
		sleep(12);		
    	$this->type("xiusAddressEl", "bhilwara");
    	$this->assertTrue($this->isElementPresent("//input[@name='find']"));
		$this->click("//input[@name='find']");
		sleep(2);
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "150");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
    	
    	// check the condition occurs in applied info or not
    	//$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Array'][@id='8']"));
	
		// check no of user must be listed
		$this->assertTrue($this->isElementPresent("//span[@id='total_13']"));
		
		// now search male from bhilwara
		$this->select("//div[@id='xius_Info_Ref4']/div[2]/select", "label=Male");
		//$this->select("//select[@id='field2']", "label=Male");
		$this->click("//img[@class='xius_test_addinfo_4']");
		$this->waitPageLoad(); 
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Male']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));
		// remove gender = male info from conditon
		$this->click("//img[@class='xius_test_remove_Male']");
		$this->waitPageLoad();
		
		// now search female from bhilwara near by 150 miles
		$this->select("//select[@id='field2']", "label=Female");
		//$this->select("//select[@id='field2']", "label=Female");
		$this->click("//img[@class='xius_test_addinfo_4']");
		$this->waitPageLoad(); 
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Female']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_5']")); // because 2 user does not have gender saved
		
		// remove gender = female info from conditon
		$this->click("//img[@class='xius_test_remove_Female']");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//span[@id='total_13']"));
	}
	
	function testSearchByGoogleAPIOne()
	{
		$this->loadSqlFiles();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSearchByGoogleAPI.start.sql');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// search users female from mubai with 400 kms distance from surat
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");	
		sleep(12);		
    	$this->type("xiusAddressEl", "Surat");
    	$this->click("find");
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "400");
    	$this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
    	$this->select("//select[@id='field2']", "label=Female");
    	$this->type("//input[@id='field11']", "Mumbai");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
    	
    	// remove gender=female infor from applied info
    	$this->click("//img[@class='xius_test_remove_Female']");
    	$this->waitPageLoad();

    	// add gender=male to applied oinfo
    	$this->select("//select[@id='field2']", "label=Male");
		$this->click("//img[@class='xius_test_addinfo_4']");
		$this->waitPageLoad(); 
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
		
		// remove gender=male infor from applied info
    	$this->click("//img[@class='xius_test_remove_Male']");
    	$this->waitPageLoad();
    	
    	// remove city=munbai infor from applied info
    	$this->click("//img[@class='xius_test_remove_Mumbai']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_13']"));		
	}
	
	function testProximityInvalidGeocodes()
	{
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// search users from Ahmedabad with distance 200 kms( no user from surat, have invalid geocodes)
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");
		sleep(12);		
    	$this->type("xiusAddressEl", "Ahmedabad");
    	$this->click("find");
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "210");
    	$this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_4']"));
		
		$this->loadSqlFiles();
		
		// search users from Ahmedabad with distance 200 kms(users from surat, have valid geocodes)
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");
		sleep(12);		
    	$this->type("xiusAddressEl", "Ahmedabad");
    	$this->click("find");
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "210");
    	$this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
		$this->assertTrue($this->isElementPresent("//span[@id='total_6']"));		
	}
	
	function testGoogleProximityWithSameCondition()
	{
		$this->loadSqlFiles();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSearchByGoogleAPI.start.sql');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// search users female from mubai with 400 kms distance from surat
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");		
		sleep(12);		
    	$this->type("xiusAddressEl", "Mumbai");
    	$this->click("find");
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "400");
    	$this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_7']"));
		//$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Array'][@id='8']"));
    	$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");		
		sleep(12);		
    	$this->type("xiusAddressEl", "Mumbai");
    	$this->click("find");
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "400");
    	$this->select("//select[@id='Proximitygoogle_userForm_dis_unit']", "label=Kms");
    	$this->select("//select[@id='field2']", "label=Female");		
    	$this->type("//input[@id='field11']", "Mumbai");
    	$this->click("//img[@class='xius_test_addinfo_8']");
    	$this->waitPageLoad();
    	//$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Array'][@id='8']"));
    	// XITODO : assert on below condition
    	//$this->assertEquals($this->getXpathCount("//img[contains(@class, 'xius_test_remove_Array')]"), 1);
	}
	
	function testSortByDisatance()
	{
		$this->loadSqlFiles();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSearchByGoogleAPI.start.sql');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		
		// search users from bhilwara
		$this->click("//input[@id='Proximitygoogle_userForm_option'][@value='googlemap']");
		$this->click("//a[@id='Proximitygoogle_userForm_map_button']");
		sleep(10);
		$this->type("xiusAddressEl", "bhilwara");
    	$this->assertTrue($this->isElementPresent("//input[@name='find']"));
		$this->click("//input[@name='find']");
		sleep(2);
    	$this->click("sbox-btn-close");
    	sleep(2);
    	$this->type("Proximitygoogle_userForm_dis", "150");
    	$this->click("xiussearch");
    	$this->waitPageLoad();
		// check no of user must be listed
		$this->assertTrue($this->isElementPresent("//span[@id='total_13']"));
		
		// sort 
		$this->select("limit", "label=5");
		$this->waitPageLoad();
		$this->select("xiussort", "label=GOOGLE API");
		$this->waitPageLoad();		
		$this->select("xiussortdir", "label=ASC");
		
		$avatar[] = "//img[@id='avatar_62']";
		$avatar[] = "//img[@id='avatar_84']";
		$avatar[] = "//img[@id='avatar_90']";
		$avatar[] = "//img[@id='avatar_108']";
		$avatar[] = "//img[@id='avatar_115']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->select("xiussortdir", "label=DESC");
		$this->waitPageLoad();
		$avatar[] = "//img[@id='avatar_96']";
		$avatar[] = "//img[@id='avatar_111']";
		$avatar[] = "//img[@id='avatar_118']";
		$avatar[] = "//img[@id='avatar_87']";
		$avatar[] = "//img[@id='avatar_109']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("//img[@class='xius_test_remove_Array'][@id='8']");
		$this->waitPageLoad();
		$avatar[] = "//img[@id='avatar_120']";
		$avatar[] = "//img[@id='avatar_119']";
		$avatar[] = "//img[@id='avatar_118']";
		$avatar[] = "//img[@id='avatar_117']";
		$avatar[] = "//img[@id='avatar_116']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
	}
}
