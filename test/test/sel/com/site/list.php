<?php

class XiusListTest extends XiSelTestCase
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
		
	function testSaveList()
	{
		$this->loadSql();		
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
				
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	$this->waitPageLoad();
    	
		$element = "//img[@class='xius_test_remove_Male']";
		$this->click($element);
		$this->waitPageLoad();
		
		$this->select("field2", "label=Female");
   	   	$this->click("//img[@class='xius_test_addinfo_1']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->click("//img[@title='Save This List']");
		
		$this->waitForElement('sbox-window');
		sleep(2);
		
 		$this->assertEquals("1", $this->getValue("name=listid value=1"));
        $this->assertEquals("off", $this->getValue("name=listid value=2"));
        
	    $this->type("xius_list_name", "Female From Afghanistan");
    	$this->type("xius_list_desc", "All Female from afghanistan");
    	$this->click("xiussavenew");
    	
	    sleep(3);
	    $this->waitPageLoad();
        $this->assertTrue($this->isTextPresent("Female From Afghanistan"));
        	
	}
	
	function testListEditing()
	{				
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=2');
    	$this->waitPageLoad();
    	$this->assertFalse($this->isElementPresent("//img[@title='Save']"));
    	
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=2');
    	$this->waitPageLoad();
    	
		$element = "//img[@class='xius_test_remove_16-1-2010']";
		$this->click($element);
		$this->waitPageLoad();
				
		$this->type("field11", "Noida");
   	   	$this->click("//img[@class='xius_test_addinfo_2']");
    	$this->waitPageLoad();

    	$this->type("field11", "Jaipur");
   	   	$this->click("//img[@class='xius_test_addinfo_2']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->click("//img[@title='Save This List']");
		
		$this->waitForElement('sbox-window');
		sleep(2);
		
 		$this->assertEquals("off", $this->getValue("name=listid value=1"));
        $this->assertEquals("2", $this->getValue("name=listid value=2"));
        
	   /* $this->type("xius_list_name", "Users from Noida or Jaipur");
    	$this->type("xius_list_desc", "Users from Noida or Jaipur");*/
    	$this->click("xiussaveexisting");
    	
	    sleep(3);
	    $this->waitPageLoad();
        $this->assertTrue($this->isTextPresent("Register Date is 16-01-2010"));
	}

	function testListByRemovingInfo()
	{
		$this->loadSql();
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	$this->waitPageLoad();
    	
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_Jaipur']"));
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
    	
    	$this->click("//img[@class='xius_test_remove_Male']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_3']"));    	
	}
	
	

	function testListDisplayWithForcesearch()
	{
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=3');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_1']"));
		
        $this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=4');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));

    	//IMP : Force search is not applicable to admin
    	$this->frontLogin('admin','ssv445');
    	$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=3');
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));

	$this->frontLogout();
	}
	
	function testListPagination()
	{
		$filter['sef'] = 0;
		$this->updateJoomlaConfig($filter);
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusListTest/testListEditing.start.sql');
				
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	$this->waitPageLoad();
    	$this->checkListPagination();
    	
		$filter['sef'] = 1;
		$this->updateJoomlaConfig($filter);

    	$sql= " DELETE FROM `#__menu` WHERE `name`='Male from Afghanistan' ";
    	$db = JFactory::getDBO();
    	$db->setQuery($sql);
    	$db->query();
    	    	
    	$sql = " INSERT INTO `#__menu` (`menutype`, `name`, `alias`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`, `lft`, `rgt`, `home`) VALUES
    	('mainmenu', 'Male from Afghanistan', 'male-from-afghanistan', 'index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=1', 'component', 1, 0, 81, 0, 11, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0)";
    	$db->setQuery($sql);
    	$db->query();
    	
    	$sql= " SELECT `id` FROM `#__menu` WHERE `name`='Male from Afghanistan' ";
    	$db = JFactory::getDBO();
    	$db->setQuery($sql);
    	$result=$db->loadResult();
    	
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
    	$this->waitPageLoad();
    	$val = 'item'.$result;    	
    	$this->click("//li[@class=\"$val\"]/a");
    	$this->waitPageLoad();
    	$this->checkListPagination();
	}
	
	function checkListPagination()
	{		
    	$this->select('xiusjoin',"label=Match Any");
		$this->waitPageLoad();
    	$this->select('field12',"label=Algeria");
    	$this->click("//img[@class='xius_test_addinfo_3']");
		$this->waitPageLoad();
		$this->select('limit',"label=10");		
		$this->waitPageLoad();
		$this->select('limit',"label=5");		
		$this->waitPageLoad();
				
		$avatar[] = "//img[@id='avatar_92']";
		$avatar[] = "//img[@id='avatar_111']";
		$avatar[] = "//img[@id='avatar_79']";
		$avatar[] = "//img[@id='avatar_120']";
		$avatar[] = "//img[@id='avatar_104']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		$this->click("link=2");
		$this->waitPageLoad();
		$avatar[] = "//img[@id='avatar_108']";
		$avatar[] = "//img[@id='avatar_67']";
		$avatar[] = "//img[@id='avatar_90']";
		$avatar[] = "//img[@id='avatar_89']";
		$avatar[] = "//img[@id='avatar_94']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
		
		
		$this->click("link=Next");
		$this->waitPageLoad();
		$avatar[] = "//img[@id='avatar_77']";
		$avatar[] = "//img[@id='avatar_66']";
		$avatar[] = "//img[@id='avatar_112']";
		$avatar[] = "//img[@id='avatar_82']";
		$avatar[] = "//img[@id='avatar_101']";
		$this->isSearchElementPresent($avatar);
		unset($avatar);
	}
}
