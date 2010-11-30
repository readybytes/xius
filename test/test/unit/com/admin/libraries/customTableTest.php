<?php

class XiusCustomTableTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	

	function testGetAvailableInfo()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		$instance = new Customtable();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);

		$info = $instance->getAvailableInfo();
		$db 	= JFactory::getDBO();
		$prefix = $db->getPrefix();
		
		$this->assertTrue(array_key_exists('xius_dummy_customtable', $info));
		$this->assertTrue(array_key_exists($prefix.'xius_info', $info));
		$this->assertTrue(array_key_exists($prefix.'xius_list', $info));
		$this->assertTrue(array_key_exists($prefix.'xius_config', $info));			
	}
	
	function testGetTableMapping()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusCustomTableTest/testGetAvailableInfo.start.sql');
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		
		$instance = new Customtable();
		$instance->load(6);
		$mapping = $instance->getTableMapping();
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= 'xius_dummy_customtable';
		$object->tableAliasName 	= "Customtablexius_dummy_customtablename_0";
		$object->originColumnName	= 'name';
		$object->cacheColumnName	= 'customtablexius_dummy_customtablename_0';
		$object->cacheSqlSpec 		= 'text NOT NULL ';
		$object->cacheLabelName		= 'Custom Name';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);		
	}
	
	function testGetUserData()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusCustomTableTest/testGetAvailableInfo.start.sql');
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		
		$instance = new Customtable();
		$instance->load(6);
		$query = new XiusQuery();
		$instance->getUserData($query);
		$str = $query->__toString();
		$comparestr = "SELECTjuser.`id`asuserid,Customtablexius_dummy_customtablename_0.nameascustomtablexius_dummy_customtablename_0FROM`#__users`"
						."asjuserLEFTJOINxius_dummy_customtableasCustomtablexius_dummy_customtablename_0ON(Customtablexius_dummy_customtablename_0.`id`=juser.`id`)";
		$this->assertEquals($this->cleanWhiteSpaces($str), $comparestr); 
	}
	
	function testGetColumnspec()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusCustomTableTest/testGetAvailableInfo.start.sql');
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		
		$instance = new Customtable();
		$instance->load(6);
		$spec = $instance->getCacheSqlSpec($instance->getData('key'));
		$this->assertEquals($this->cleanWhiteSpaces($spec), 'textNOTNULL');			
		
		$instance = new Customtable();
		$instance->load(5);
		$spec = $instance->getCacheSqlSpec($instance->getData('key'));
		$this->assertEquals($this->cleanWhiteSpaces($spec), 'dateNOTNULL');
	}
	
	function testCacheTableCreated()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusCustomTableTest/testGetAvailableInfo.start.sql');
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		
		XiusLibrariesUsersearch::updateCache();
		
		$this->_DBO->addTable('#__xius_cache');
	}
	
	function testSearch()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusCustomTableTest/testGetAvailableInfo.start.sql');
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'customtable' . DS . 'customtable.php';
		
		XiusLibrariesUsersearch::updateCache();
		$post			= array('xiusinfo_61'=>6,'Customtable_6'=>'user','xiusinfo_62'=>6);
		
		$conditions		= XiusLibrariesUsersearch::processSearchData($post);				
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'OR','XIUS');
		
		$data = array(array());
		XiussiteHelperResults::_getInitialData(&$data);
		XiussiteHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],3);		
	}	
}

