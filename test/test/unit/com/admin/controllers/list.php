<?php

class XiusControllerListTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testRemoveList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php'; 
		
		$listController = new XiusControllerList();
		
		$delInfoIds = array(1);
		
		$db = JFactory::getDBO();
		
		$result = $listController->_remove($delInfoIds);
		$this->assertTrue($result['success']);		
	}
	
	
	function testPublishList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php'; 
		
		$listController = new XiusControllerList();
		
		$infoIds = array(1,2);
		
		$db = JFactory::getDBO();
		
		$result = $listController->_updatePublish(1,$infoIds);
		$this->assertTrue($result['success']);		
	}
	
	function testUnPublishList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php'; 
		
		$listController = new XiusControllerList();
		
		$infoIds = array(1,2);
		
		$db = JFactory::getDBO();
		
		$result = $listController->_updatePublish(0,$infoIds);
		$this->assertTrue($result['success']);		
	}
		
	

	function testOrderUpList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		//$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php'; 
		
		$listController = new XiusControllerList();
		
		$infoIds = array(2);
		
		$db = JFactory::getDBO();
		
		$result = $listController->_saveOrder($infoIds,-1);
		$this->assertTrue($result['success']);		
	}
	

	function testOrderDownList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		//$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php'; 
		
		$listController = new XiusControllerList();
		
		$infoIds = array(1);
		
		$db = JFactory::getDBO();
		
		$result = $listController->_saveOrder($infoIds,1);
		$this->assertTrue($result['success']);		
	}
}
?>
