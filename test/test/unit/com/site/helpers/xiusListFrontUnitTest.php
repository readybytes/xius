<?php

class XiusListFrontUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testFilterListPrivacy()
	{
		$lModel =& XiusFactory::getModel('list','admin');

		$filter = array();
		$user = & JFactory::getUser(63);
		$user->usertype = "Editor";
		$lists = $lModel->getLists($filter,'AND',true);
		
		// filter list according to privacy set by joomla
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$this->checkListExists($lists,array(1,3),array(2));
		
		$user->usertype = "Publisher";
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$this->checkListExists($lists,array(3),array(1,2));
		
		$user->usertype = '';
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$this->checkListExists($lists,array(3),array(1,2));
		
		$user->usertype = 'Super Administrator';
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$this->checkListExists($lists,array(1,2,3),array());
	}
	
	function checkListExists($lists, $exists,$notExists)
	{
		foreach($lists as $list){
			$this->assertTrue(in_array($list->id,$exists));
			$this->assertFalse(in_array($list->id,$notExists));
		}
			
	}
}