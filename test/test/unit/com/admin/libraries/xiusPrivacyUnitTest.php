<?php

class XiusPrivacyUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	/**
	 * @dataProvider accessibleInfoProvider
	 */
	function testCoreAccessibility($type,$accessibleGroup)
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testCoreAccessibility.sql');
		$this->resetCachedData();
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		$access= array();
		if(empty($allInfo))
			$this->assertTrue(0);
			
		$user	= & JFactory::getUser(63);
		foreach($type as $t){  
			foreach($allInfo as $info){        	  
				//$plgInstance = XiusFactory::getPluginInstance($info->id);
				$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
				$plgInstance->bind($info);
			
				$user->usertype = $t;
				$access[$info->labelName][$t] = $plgInstance->isCoreAccessible($user);
			}
		}
		$this->assertEquals($access,$accessibleGroup);
	}
			
	static function accessibleInfoProvider()
	{
		$accessibleGroup['State'] = array (
    								'Registered' => true,
    								'Editor' => true,
    								'Author' => true,
    								'Publisher' => true,
    								'Administrator' => true,
    								'Super Administrator' => true,
    								'Manager' => true,
									'Guest Only' => true
  								);
  								
		$accessibleGroup['Country']=  
  								array(
    								'Registered' => true,
    								'Editor' => true,
    								'Author' => true,
    								'Publisher' => true,
    								'Administrator' => true,
    								'Super Administrator' => true,
    								'Manager' => true,
									'Guest Only' => true
  								);
  								
  		$accessibleGroup['City / Town'] = 	array (
    								'Registered' => true,
    								'Editor' => true,
    								'Author' => true,
    								'Publisher' => true,
    								'Administrator' => true,
    								'Super Administrator' => true,
    								'Manager' => true,
									'Guest Only' => true
  								);
  								
  		$accessibleGroup['Gender'] = array (
    								'Registered' => true,
    								'Editor' => false,
    								'Author' => false,
    								'Publisher' => true,
    								'Administrator' => false,
    								'Super Administrator' => true,
    								'Manager' => false,
 									'Guest Only' => false
  								);
  								
		$accessibleGroup['Birthday'] =	array (
    								'Registered' => false,
    								'Editor' => false,
    								'Author' => true,
    								'Publisher' => false,
    								'Administrator' => false,
    								'Super Administrator' => true,
    								'Manager' => true,
									'Guest Only' => true
  								);
  		$accessibleGroup['Age'] = array (
    								'Registered' => true,
    								'Editor' => false,
    								'Author' => false,
    								'Publisher' => true,
    								'Administrator' => false,
    								'Super Administrator' => true,
    								'Manager' => false,
  									'Guest Only' => false
  								);
  								
  		$type = array('Registered','Editor','Author','Publisher',
						'Administrator','Super Administrator', 'Manager','Guest Only');

  		return array(
			array($type,$accessibleGroup),			
		);
	}
}

