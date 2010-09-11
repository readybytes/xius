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
	
	function testSaveList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->resetCachedData();		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'list.php';		
		$listController = new XiusControllerList();
		
		$post['id']	= 1; 
		$post['xiusListName']='Male from Afghanistan';
		$post['xiusListVisibleInfo']='';
		$post['xiusListSortInfo']=3;
		$post['xiusListSortDir']='ASC';
		$post['xiusListJoinWith']='OR';
		$post['xiusListDescription']='<b>Male from Afghanistan</b>';
		$post['published']=0;
		$post['params']['xiusListViewGroup'][] = 'All';
		$post['js_privacy'] = 'public';
		$returnData = $listController->_processSave($post);
		
		unset($post);
		$this->resetCachedData();
		$post['id']	= 2; 
		$post['xiusListName']='Register Date';
		$post['xiusListVisibleInfo']='';
		$post['xiusListSortInfo']=2;
		$post['xiusListSortDir']='DESC';
		$post['xiusListJoinWith']='OR';
		$post['xiusListDescription']='<b>Register</b>';
		$post['published']=1;		
		$post['js_privacy'] = 'public';
		$post['params'] = array();
		$returnData = $listController->_processSave($post);
	}
}
?>
