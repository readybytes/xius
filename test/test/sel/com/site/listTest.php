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
		$this->enablefunction();
		
		$this->loadSql();		
		$this->_DBO->addTable('#__xius_list');
		//$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');

		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=list&task=showList&usexius=1&listid=1');
    	$this->waitPageLoad(); 	
    	
		$element = "//img[@class='xius_test_remove_Male']";
		$this->click($element);
		$this->waitPageLoad();
		
		$this->click("xiusSliderImg");
		$this->select("field2", "label=Female");
   	   	$this->click("//img[@class='xius_test_addinfo_1']");
    	$this->waitPageLoad();
    	
    	$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->click("//img[@title='Save This List']");
		sleep(2);
		$this->click("xiusListSaveAs");
		$this->waitPageLoad();
		
		$this->type("xiusListName", "All female From Afghanistan");
		$this->assertTrue($this->isTextPresent("Jom Social Privacy"));
		$this->assertChecked("//input[@id='paramsjs_privacypublic']");
		$this->click("link=Toggle editor");
		$this->type("xiusListDesc", "All Female from afghanistan");
		$this->click("link=Toggle editor");
 	   	$this->click("xiussave");

	    $this->waitPageLoad();
	    $this->assertTrue($this->isTextPresent("List has been saved successfully"));
        $this->assertTrue($this->isTextPresent("All female From Afghanistan"));
        $this->frontLogout();
       
		$this->disablefunction();
        	
	}
	
	function testListEditing()
	{				
		$this->enablefunction();
		
		$this->_DBO->addTable('#__xius_list');
		//$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=list&task=showList&usexius=1&listid=3');
    	$this->waitPageLoad();
    	$this->click("//img[@title='Save This List']");
    	
    	$this->waitForElement('sbox-window');
    	sleep(2);
    	$this->click("xiusListSaveAsExisting");
   		$this->select("//select[@id='listid']", "label=Male From Afghanistan");    
   
       	$this->click("xiusListSaveAs");
		$this->waitPageLoad();
		
		$this->type("xiusListName", "Female From Afghanistan");
		$this->click("paramsjs_privacyfriend");
		$this->click("link=Toggle editor");
		$this->type("xiusListDesc", "<p>All female From Afghanistan</p>");
		$this->click("link=Toggle editor");
    	
		$this->click("xiussave");
	    $this->waitPageLoad();
	    $this->assertTrue($this->isTextPresent("List has been saved successfully"));
        $this->assertTrue($this->isTextPresent("Female From Afghanistan"));
        $this->frontLogout();
        
        $this->disablefunction();
	}

	function testListByRemovingInfo()
	{
		$this->enablefunction();
		
		$this->loadSql();
 		
		$this->frontLogin('admin','ssv445');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=list&task=showList&usexius=1&listid=1');
    	$this->waitPageLoad();
    	
    	$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_Jaipur']"));
    	$this->assertTrue($this->isElementPresent("//span[@id='total_2']"));
    	
    	$this->click("//img[@class='xius_test_remove_Male']");
    	$this->waitPageLoad();
    	$this->assertTrue($this->isElementPresent("//span[@id='total_3']"));
    	
    	$this->disablefunction();
	}
	
	
	function testListWithPrivacy(){
		
		$this->enablefunction();
		
		//load database Info
		$url=dirname(__FILE__).'/sql/'.__CLASS__.'/'.__FUNCTION__.'.start.sql';
		$this->_DBO->loadSql($url);
		
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_community&view=list&task=showList&usexius=1&listid=5');
		$this->assertTrue($this->isTextPresent("All user"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_59']"));
		
		$this->privacyForFreeMember();
		$this->privacyForSeriousJoomlaUser();
		$this->privacyForPaidSubscriber();
		$this->privacyModerator();
		
						
		$this->disablefunction();
	}
	
	function privacyForFreeMember(){
		//for freeMember
		$this->frontLogin('username10', 'password10');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
    	$this->waitPageLoad();
		$this->assertFalse($this->isTextPresent("All female From Afghanistan"));
		$this->assertFalse($this->isTextPresent("All Amrican female"));
		$this->assertTrue($this->isTextPresent("Register Date is 16-01-2010"));
		$this->frontLogout();
	}
	
	function privacyForPaidSubscriber(){
		// Administrator, frnd of user60
		$this->frontLogin('username20', 'password20');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=list&task=showList&listid=6');
    	$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("user list"));
		$this->assertTrue($this->isElementPresent("//img[@title='Save This List']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_58']"));		
		$this->frontLogout();
		
		
	}
	
	function privacyForSeriousJoomlaUser(){
		//for SeriousJoomlaUser
		$this->frontLogin('username60', 'password60');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
    	$this->waitPageLoad();
    	$this->type("Joomla_5", "name");
    	$this->click("xiussearch");
		$this->waitPageLoad();
		$this->click("//img[@title='Save This List']");
    	$this->waitForElement('sbox-window');
    	sleep(2);
    	$this->click("xiusListSaveAs");
    	$this->waitPageload(); 
    	$this->type("xiusListName", "user list");
    	
    	//visible for JS friends
		$this->click("paramsjs_privacyfriend");
		$this->click("xiussave");
		$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("List has been saved successfully"));
		$this->frontLogout();
		
		// username40 frnd of username60.....so testing list displaying or not
		// username40 is not editng in list
		// username40 may be moderator bt nt editing in list 
		// Beecoz username40 is only publisher
		
		$this->frontLogin('username40', 'password40');
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=list&task=showList&listid=6');
    	$this->waitPageLoad();
    	$this->assertTrue($this->isTextPresent("user list"));
    	$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_name']"));
    	$this->assertTrue($this->isElementPresent("//span[@id='total_58']"));
    	$this->assertFalse($this->isElementPresent("//img[@title='Save This List']"));
    	$this->frontLogout();
	}
	
	function privacyModerator(){
		//for Moderator
		$this->frontLogin('username40', 'password40');
		$this->open(JOOMLA_LOCATION.'index.php?option=com_xius&view=list&task=showList&listid=1');
    	$this->waitPageLoad();
		$this->assertTrue($this->isTextPresent("Male From Afghanistan"));
		$this->assertFalse($this->isTextPresent("All Amrican female"));
		$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_Afghanistan']"));
		$this->assertTrue($this->isElementPresent("//span[@id='total_0']"));
		$this->frontLogout();
	}

	function xtestListDisplayWithForcesearch()
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
	
	function xtestListPagination()
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
    	$this->select('xiusjoin',"label=Any");
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
	
	function enablefunction(){
		//Enable xipt_privacy plugin
		$this->changePluginState('xipt_privacy', true);
		
		//Enable xipt plugins
		$this->changePluginState('xipt_community', true);
		$this->changePluginState('xipt_system', true);
		
		//Enable xius list module
 		$this->changeModuleState('mod_xiuslisting',true);
			
	}
	
	function disablefunction(){
		//Disable xius list module
 		$this->changeModuleState('mod_xiuslisting',false);
 		
 		//Disable xipt plugins
		$this->changePluginState('xipt_community', false);
		$this->changePluginState('xipt_system', false);
		
		//Disable xipt_privacy plugin
		$this->changePluginState('xipt_privacy', false);
	}
}
