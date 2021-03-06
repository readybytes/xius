<?php
require_once 'PHPUnit/Framework.php';

class XiUnitTestCase extends PHPUnit_Framework_TestCase
{
  var  $_DBO;
  function setUp()
  {
  	//XiFactory::getErrorObject()->setError('');
  	require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
  	$this->resetCachedData();
  	//$this->parentSetup();
  	$this->setAutoCronSetup(0);
  }


  function assertPreConditions()
  {
  	//import System plugins 
  	JPluginHelper::importPlugin( 'system' );
  	
    // this will be a assert for every test
    if(method_exists($this,'getSqlPath'))
        $this->assertEquals($this->_DBO->getErrorLog(),'');
  }

  function assertPostConditions()
  {
     // if we need DB based setup then do this
     if(method_exists($this,'getSqlPath'))
         $this->assertTrue($this->_DBO->verify());
  }


  function compareArray($firstArray,$secondArray,$conditions='')
  {
  	//echo "\nin fn";
  	if(!$conditions)
  		$conditions=array('checkAccFirst' => false , 'checkAccSecond' => false , 'bothEqual' => true);

  	if(isset($conditions['bothEqual']) && $conditions['bothEqual'] === true){
  		//echo "\nin both equal";
  		$this->assertEquals(count($firstArray),count($secondArray));
  		foreach($firstArray as $k => $v) {
	  		$this->assertTrue(isset($secondArray[$k]),"$k is not set in secondArray");
	  		$this->assertEquals($v,$secondArray[$k],"value on key $k should be $v , get ".$secondArray[$k]);
	  	}
  	}

  	if(isset($conditions['checkAccFirst']) && $conditions['checkAccFirst'] === true) {
	  	//echo "\nin first";
  		foreach($firstArray as $k => $v) {
	  		//echo "\nset $k = ".isset($secondArray[$k]);
	  		$this->assertTrue(isset($secondArray[$k]),"$k is not set in secondArray");
	  		$this->assertEquals($v,$secondArray[$k],"value on key $k should be $v , get ".$secondArray[$k]);
	  	}
  	}

  	if(isset($conditions['checkAccSecond']) && $conditions['checkAccSecond'] === true) {
	  	//echo "\nin second";
  		foreach($secondArray as $k => $v) {
	  		$this->assertTrue(isset($firstArray[$k]),"$k is not set in firstArray");
	  		$this->assertEquals($v,$firstArray[$k],"value on key $k should be $v , get ".$firstArray[$k]);
	  	}
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


	function cleanWhiteSpaces($str)
	{
		$str = preg_replace('#[\\n\\b\\s\\t]+#','' , $str);
		return $str;
	}


	function resetCachedData()
	{
		require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';
		$fields = Jsfieldshelper::getAllJomsocialFields(true);

		$allInfo = XiusLibInfo::getAllInfo(true);
		XiusFactory::getInstance ('users','model','',true);
		XiusFactory::getInstance ('configuration','model','',true);
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
 	
	function get_js_version()
  	{	
		$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';

		$parser		=& JFactory::getXMLParser('Simple');
		$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';

		$parser->loadFile( $xml );

		$doc		=& $parser->document;
		$element	=& $doc->getElementByPath( 'version' );
		$version	= $element->data();

		return $version;
  	}
  	
	function changeModuleState($modname, $action=1)
  	{
  	
		$db			= JFactory::getDBO();
		$query	= 'UPDATE ' . $db->nameQuote( '#__modules' )
				. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	.' WHERE '.$db->nameQuote('module').'='.$db->Quote($modname);

		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
 	 }
 
	function changePluginState($pluginname, $action=1)
   	{
  	
		$db			=& JFactory::getDBO();
		if(TEST_XIUS_JOOMLA_15)
		{
		 $query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
				 . ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
	          	 .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);
		}
		else 
		{
		 $query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
				 . ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
	          	 .' WHERE '.$db->nameQuote('element').'='.$db->Quote($pluginname);	
		}
		$db->setQuery($query);		
		
		if(!$db->query())
			return false;
			
		return true;
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

}


