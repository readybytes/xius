<?php

class InstallTest extends XiSelTestCase
{
  protected $collectCodeCoverageInformation = false;

  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }

  function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION."/administrator/index.php?option=com_login");

    //verify tables setup
    $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

//  function waitPageLoad($time=TIMEOUT_SEC)
//  {
//      $this->waitForPageToLoad($time);
//  }

  function _setupXipt()
  {
  	//INSTALL XIPT 3.1 FIRST
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    $this->type("install_url", XIPT_PKG);
	if(TEST_XIUS_JOOMLA_16){ 
   		$this->click("//input[@value='Install' and @type='button' and @onclick='Joomla.submitbutton4()']");
   	}
   	if(TEST_XIUS_JOOMLA_15){
   	  	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   	}


    $this->waitPageLoad();
    if(TEST_XIUS_JOOMLA_16)
    	$this->assertTrue($this->isTextPresent("Installing component was successful."));
    if(TEST_XIUS_JOOMLA_15)
    	$this->assertTrue($this->isTextPresent("Install Component Success"));
    
    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
 }


  function testXIUSInstall()
  {
    // setup default location
    $this->adminLogin();

    //need to setup XIPT
    $this->_setupXipt();


    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    $this->type("install_url", XIUS_PKG);
    if(TEST_XIUS_JOOMLA_16){ 
   		$this->click("//input[@value='Install' and @type='button' and @onclick='Joomla.submitbutton4()']");
   	}
   	if(TEST_XIUS_JOOMLA_15){
   	  	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   	}

    $this->waitPageLoad();
    
    if(TEST_XIUS_JOOMLA_16)
    	$this->assertTrue($this->isTextPresent("Installing component was successful."));
    if(TEST_XIUS_JOOMLA_15)
		$this->assertTrue($this->isTextPresent("Install Component Success"));

    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

    $this->verifyInstallation();
  }


  function testXIUSUpgrade()
  {
    // setup default location
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    $this->type("install_url", XIUS_PKG);
  	
    if(TEST_XIUS_JOOMLA_16){ 
   		$this->click("//input[@value='Install' and @type='button' and @onclick='Joomla.submitbutton4()']");
   	}
   	if(TEST_XIUS_JOOMLA_15){
   	  	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
   	}

    $this->waitPageLoad();
    
    if(TEST_XIUS_JOOMLA_16)
    	$this->assertTrue($this->isTextPresent("Installing component was successful."));
    if(TEST_XIUS_JOOMLA_15)
		$this->assertTrue($this->isTextPresent("Install Component Success"));

    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

    $this->verifyInstallation();
  }


  function testXiUSUninstallReinstall()
  {
    // setup default location
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    if(TEST_XIUS_JOOMLA_15){
	    	$this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
			$this->waitPageLoad("30000");
     		$order = $this->getUninstallOrder('com_xius');
    		$this->click("cb$order");
    		$this->click("link=Uninstall");
     		$this->waitPageLoad();
     		$this->assertTrue($this->isTextPresent("Uninstall Component Success"));
	}
	if (TEST_XIUS_JOOMLA_16){
	    	$this->click("link=Manage");
    		$this->waitPageLoad();
    		$this->type("filters_search", "xius");
    		$this->click("//button[@type='submit']");
    		$this->waitPageLoad();
    		$this->click("cb0");
    		$this->click("link=Uninstall");
    		$this->waitPageLoad();
    		$this->assertTrue($this->isTextPresent("Uninstalling component was successful."));	
	}

    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
    $this->verifyUninstall();

     // now reinstallation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();
    $this->type("install_url", XIUS_PKG);
   
   if(TEST_XIUS_JOOMLA_16){ 
  		$this->click("//input[@value='Install' and @type='button' and @onclick='Joomla.submitbutton4()']");
	}
  	if(TEST_XIUS_JOOMLA_15){
  	  	$this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
  	}

    $this->waitPageLoad();
    
    if(TEST_XIUS_JOOMLA_16)
    	$this->assertTrue($this->isTextPresent("Installing component was successful."));
    if(TEST_XIUS_JOOMLA_15)
		$this->assertTrue($this->isTextPresent("Install Component Success"));

    $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

    $this->verifyInstallation();
  }

  function verifyUninstall()
  {
  	//XiTODO:: Why commented folloeing code.
//  		$this->verifyExtensionState("plugin","xius_system",false,'system');
//  		$this->verifyExtensionState("plugin","xius",false,'community');
//  		$this->verifyExtensionState("module","mod_xiuslisting",false);
//  		$this->verifyExtensionState("module","mod_xiussearchpanel",false);
  }


 function verifyInstallation()
 {
  		$this->verifyExtensionState("plugin","xius_system",true,'system');
  		$this->verifyExtensionState("plugin","xius",true,'community');
  		//XiTODO:: Why commented folloeing code. Use it.
  		//$this->verifyExtensionState("module","mod_xiuslisting",false);
  		//$this->verifyExtensionState("module","mod_xiussearchpanel",false);
  }

  function getUninstallOrder($component, $what = "COMPONENT")
  {
  	$db = JFactory::getDBO();
  	$sql = "SELECT * FROM `#__components`
  			WHERE `parent` = '0'
  			ORDER BY `iscore`, `name`";
  	$db->setQuery($sql);
    $results = $db->loadAssocList();

    $i=0;
    foreach($results as $r)
    {
    	if($r['option']==$component)
    		return $i;

    	$i++;
    }

    return -1;
  }

  function testVerifyCronRun()
  {
  	$this->open(JOOMLA_LOCATION."index.php?option=com_community&task=cron");
    //XiTODO:: must be test it, Cache will update or not by above url
    // u can do => Check update cache time = current time.
	// $this->waitPageLoad();
    //$this->assertTrue($this->isTextPresent("Running XIUS Cron update"));
  }

}
