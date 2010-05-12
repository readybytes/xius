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
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';
		$fields = Jsfieldshelper::getAllJomsocialFields(true);
		
		$allInfo = XiusLibrariesInfo::getAllInfo(true);
		XiusFactory::getModel('users','site',true);
	}
  
}


