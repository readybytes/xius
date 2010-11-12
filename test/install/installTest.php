<?php

class InstallTest extends XiSelTestCase
{
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

  function waitPageLoad($time=TIMEOUT_SEC)
  {
      $this->waitForPageToLoad($time);
  }

  function _setupXipt()
  {
  	//INSTALL XIPT 3.0 FIRST
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

    $this->type("install_url", XIPT_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    $this->assertTrue($this->isTextPresent("Supportive Plugin/Module xipt_community Installed Successfully"));
    $this->assertTrue($this->isTextPresent("Supportive Plugin/Module xipt_system Installed Successfully"));
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
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));

    //$this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

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
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));

    //$this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

    $this->verifyInstallation();
  }


  function testXiUSUninstallReinstall()
  {
    // setup default location
    $this->adminLogin();

    // go to installation
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
    $this->waitPageLoad();

     $this->click("//a[@onclick=\"javascript:document.adminForm.type.value='components';submitbutton('manage');\"]");
     $this->waitPageLoad();

     //now find the component order in uninstall list
     $order = $this->getUninstallOrder('com_xius');
     $this->click("cb$order");
     $this->click("link=Uninstall");
     $this->waitPageLoad();
     $this->assertTrue($this->isTextPresent("Uninstall Component Success"));
     $this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));
     $this->verifyUninstall();

     // now reinstallation
     $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
     $this->waitPageLoad();

    $this->type("install_url", XIUS_PKG);
    $this->click("//form[@name='adminForm']/table[3]/tbody/tr[2]/td[2]/input[2]");
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Install Component Success"));
    //$this->assertFalse($this->isElementPresent("//dl[@id='system-error']/dd/ul/li"));

    $this->verifyInstallation();
  }

  function verifyUninstall()
  {
  		//1. Plugins are disabled

  		//1.
  		$this->verifyPluginState('xius_system',false);
  		$this->verifyPluginState('xius',false);
  		$this->verifyModuleState('mod_xiuslisting',false);
  		$this->verifyModuleState('mod_xiussearchpanel',false);
  }


 function verifyInstallation()
 {
  		//1. Plugins are disabled

  		//1.
  		$this->verifyPluginState('xius_system',true);
  		$this->verifyPluginState('xius',true);
  		$this->verifyModuleState('mod_xiuslisting',false);
  		$this->verifyModuleState('mod_xiussearchpanel',false);
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
    $this->waitPageLoad();
    $this->assertTrue($this->isTextPresent("Running XIUS Cron update"));
  }

}
