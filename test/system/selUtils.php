<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class XiSelTestCase extends PHPUnit_Extensions_SeleniumTestCase 
{
  var  $_DBO;
  protected $captureScreenshotOnFailure = TRUE;
  protected $screenshotPath = SCREENSHOT_PATH;
  protected $screenshotUrl  = SCREENSHOT_URL;

  protected $collectCodeCoverageInformation = TRUE;
  protected $coverageScriptUrl = 'http://localhost/dummy/phpunit_coverage.php';

  function setUp()
  {
  	require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
  	$this->parentSetup();
  	$this->setAutoCronSetup(0);
  }

  function click($elem)
  {
  	$this->assertTrue($this->isElementPresent($elem)," Element $elem was not found");
  	parent::click($elem);
  }
  
  function type($elem, $data)
  {
  	$this->assertTrue($this->isElementPresent($elem));
  	parent::type($elem, $data);
  }
  
  function parentSetup()
  {
  	$this->setHost(SEL_RC_SERVER);
  	$this->setPort(SEL_RC_PORT);
  	$this->setTimeout(10);
  	
  	//to be available to all childs
    $this->setBrowser("*chrome");
    $this->setBrowserUrl( JOOMLA_LOCATION);
    
    $filter['debug']=1;
    // $filter['debug_lang']=1;
    $filter['error_reporting']=6143;
//    $filter['sef'] = 1;
//    $filter['sef_suffix'] = 1;
//    $filter['list_limit'] = 20;
    $this->updateJoomlaConfig($filter);
  }
  
  function assertPreConditions()
  {
    // this will be a assert for every test
    if(method_exists($this,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function assertPostConditions()
  {
     // if we need DB based setup then do this
     	if(method_exists($this,'getSqlPath'))
         	$this->assertTrue($this->_DBO->verify());

        /* 	
     	if(!$this->isTableExist("xius_lang"))
        	return ;
        
        $db = JFactory::getDBO();
     	$query="SELECT langstr FROM `#__xius_lang` " ;
		$db->setQuery($query);		
		$untranslatstr = $db->loadResultArray();
		echo "\n Untranslated String in this page \n" ;
		print_r( var_export($untranslatstr ));
		$query="DROP TABLE `#__xius_lang` " ;;
		$db->setQuery($query);
		$db->query();
		*/       	  
  }
  
  function adminLogin()
  {
    $this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_login");
    $this->waitPageLoad();
    
    if(TEST_XIUS_JOOMLA_15)
    {
    	$this->type("modlgn_username", JOOMLA_ADMIN_USERNAME);
    	$this->type("modlgn_passwd", JOOMLA_ADMIN_PASSWORD);
    	$this->click("//form[@id='form-login']/div[1]/div/div/a");
    }
    else
    { 
    $this->type("mod-login-username", JOOMLA_ADMIN_USERNAME);
    $this->type("mod-login-password", JOOMLA_ADMIN_PASSWORD);
    $this->click("//input[@value='Log in']");
    }
   
    $this->waitPageLoad();

	if(TEST_XIUS_JOOMLA_15) 
     $this->assertTrue($this->isTextPresent("Logout"));	
    else
     $this->assertTrue($this->isTextPresent("Log out"));
    	
  }
  
  function frontLogin($username=JOOMLA_ADMIN_USERNAME, $password= JOOMLA_ADMIN_PASSWORD)
  {
	$this->open(JOOMLA_LOCATION."/index.php?option=com_user&view=login");
    $this->waitPageLoad();
    if (TEST_XIUS_JOOMLA_15){
    	$this->type("modlgn_username", $username);
    	$this->type("modlgn_passwd", $password);
    	$this->click("//form[@id='form-login']/fieldset/input");
    }
    else{
    	$this->type("modlgn-username", $username);
    	$this->type("modlgn-passwd", $password);
    	$this->click("Submit");
    }
  	$this->waitPageLoad();
    if (TEST_XIUS_JOOMLA_15)
    	$this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
    else
    	$this->assertEquals("Log out", $this->getValue("//form[@id='login-form']/div[2]/input[1]"));
  }
  
  function frontLogout()
  {
  	$this->open(JOOMLA_LOCATION."/index.php");
    $this->waitPageLoad();
    if (TEST_XIUS_JOOMLA_15){
       	$this->assertEquals("Log out", $this->getValue("//form[@id='form-login']/div[2]/input"));
       	$this->click("//form[@id='form-login']/div[2]/input");
    }
    else{
    	$this->assertEquals("Log out", $this->getValue("//form[@id='login-form']/div[2]/input"));
    	 $this->click("//form[@id='login-form']/div[2]/input");
    }
    $this->waitForPageToLoad("60000");
    if (TEST_XIUS_JOOMLA_15)
    	$this->assertTrue($this->isElementPresent("modlgn_username"));
    else
    	$this->assertTrue($this->isElementPresent("modlgn-username"));
  }
  
  function waitPageLoad($time=TIMEOUT_SEC)
  {
      $this->waitForPageToLoad($time);
      // now we just want to verify that 
      // page does not have any type of error
      // XIPT SYSTEM ERROR
      $this->assertFalse($this->isTextPresent("( ! ) Notice:"));
      $this->assertFalse($this->isTextPresent("500 - An error has occurred."));
      $this->assertFalse($this->isTextPresent("XIPT-SYSTEM-ERROR"));
      // a call stack ping due to assert/notice etc.
  }
  
  function waitForElement($element)
  {
	  //wait for ajax window
  		for ($second = 0; ; $second++) {
	        if ($second >= 10) $this->fail("timeout");
	        try {
	            if ($this->isElementPresent($element)) break;
	        } catch (Exception $e) {}
	        sleep(1);
	    }
  }
  
  function changeJomSocialConfig($filters)
  {
	require_once (JPATH_BASE . '/components/com_community/libraries/core.php' );
	$query = "SELECT params FROM `#__community_config` WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__community_config` SET `params`='".$paraStr."' WHERE `name`='config'";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  }
  
  function changeJSPTConfig($filters)
  {
 
  	if(!$filters)
  		return;
  		
	$query = "SELECT params FROM `#__components` WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1 ";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$params=$db->loadResult();
	
	$newParams = new JParameter($params);
	
	foreach($filters as $key => $value)
		$newParams->set($key,$value);
		
	$paraStr = '';
	$allData = $newParams->_registry['_default']['data']; 
	foreach ($allData as $key => $value)
		$paraStr .= "$key=$value\n";
		
	$query = "UPDATE `#__components` SET `params`='".$paraStr."' WHERE `parent`='0' AND `option` ='com_xipt' LIMIT 1";
	$db	=& JFactory::getDBO();
	$db->setQuery($query);
	$db->query();
  	
	$done=true;
  }
  
  function updateJoomlaConfig($filter)
  {
	  	$config =& JFactory::getConfig();		
  		foreach($filter as $key=>$value)
  			$config->setValue($key,$value);
  		
		jimport('joomla.filesystem.file');
		$fname = JPATH_CONFIGURATION.DS.'configuration.php';
		
		system("sudo chmod 777 $fname");
			
		$configString = '';
		
		if(TEST_XIUS_JOOMLA_15){
			$configString  = $config->toString('PHP', 'config', array('class' => 'JConfig'));
		}else {
			$configString = $config->toString('PHP', array('class' => 'JConfig', 'closingtag' => false));
		}
		
  		if(!JFile::write($fname,$configString)) 
		{
			echo JText::_('ERRORCONFIGFILE');
		}
  		
  }
  
  function changePluginState($pluginname, $action=1)
  {
  		$db			=& JFactory::getDBO();
		// when Jommla Version 1.6
		
		if(TEST_XIUS_JOOMLA_15){
				$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);			
		}
        else{
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
			. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
	        .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}

		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
  
  
  /**
   * Verifies that plugin is in correct state
   * @param $pluginname : Name of plugin
   * @param $enabled : Boolean, 
   * @return unknown_type
   */
  function verifyExtensionState($type, $extensionName, $enabled=true, $pluginType="xius")
  {

		if('plugin' == $type)
			$actualState = JPluginHelper::isEnabled($pluginType,$extensionName);

		 if('module' == $type)
	        $actualState = JModuleHelper::isEnabled($extensionName);

		$this->assertEquals($actualState, $enabled);
  }


  function changeModuleState($modname, $action=1)
  {
  	
		$db			=& JFactory::getDBO();
		$query	= 'UPDATE ' . $db->nameQuote( '#__modules' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('module').'='.$db->Quote($modname);

		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
  }
  
  
  function removeCondition($remove, $count=-1)
	{
		$temp = $remove;
		foreach($remove as $key=>$val){
			if($count==0)
				break;
			$this->click("//img[@class='xius_test_remove_$key']");
			$this->waitPageLoad();
			$this->assertFalse($this->isElementPresent("//img[@class='xius_test_remove_$key']"));
			$this->assertTrue($this->isElementPresent("//span[@id='total_$val']"));
			if($count > 0) $count--;
			unset($temp[$key]);
			foreach($temp as $k=>$v)
				$this->assertTrue($this->isElementPresent("//img[@class='xius_test_remove_$k']"));
		}		
	}
	
	function isInformationExists($information,$ele="input")
	{
		foreach($information as $info=>$val){
			$element = '//'.$ele.'[@id="'.$info.'"]';
			$this->assertTrue($this->isElementPresent($element));
		}	
	}
	
	function fillInfo($information, $join)
	{
		foreach( $information as $key=>$val)
			$this->type('//input[@id="'.$key.'"]', "$val"); 
			
	    $this->select("xiusjoin", "label=$join"); // match any
	    $this->click("xiussearch");
	    $this->waitPageLoad();			
	}
	
	function isSearchElementPresent($elememt)
	{
		if(!is_array($elememt))
			$this->assertTrue($this->isElementPresent($elememt));
		else{
			foreach($elememt as $ele)		
				$this->assertTrue($this->isElementPresent($ele));
		}			
	}
	
	function isTableExist($tableName)
	{
		$mainframe = JFactory::getApplication();

		$tables	= array();
	
		$database = &JFactory::getDBO();
		$tables	= $database->getTableList();
		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
	}	
	
  function setAutoCronSetup($task = 0)
  	{
  		$cModel = XiusFactory::getInstance ('configuration', 'model','',true);
		$params = $cModel->getOtherParams('config');
		if(($params->get('xiusCronJob','1') == 0) && $task == 0){
			return;
		}
		
		$params->set('xiusCronJob',$task);
		
		//Enable xiusCronJob
		$config	= XiusFactory::getInstance( 'configuration' , 'Table','',true );
		$config->load( 'config' );
		$config->params = $params->toString('INI');
		$config->store();  	
  }
  
	function cleanWhiteSpaces($str)
	{
		$str = preg_replace('#[\\n\\b\\s\\t]+#','' , $str);
		return $str;
	}
}
