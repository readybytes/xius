<?php

class XiusControllerUsersTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testSaveNewUserlist()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'users.php'; 
		
		$userController = new XiusControllerUsers();
		
		$datas = array();
		$conditions1 = array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '='));
		$url1 = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid=1',false);
		$datas[] = array('info' => array('id' => 0 , 'owner' => 62 , 'name' => 'Male from Afghanistan' , 'sortinfo' => 4 , 'sortdir' => 'DESC' , 'join' => 'AND' , 'conditions' => serialize($conditions1) , 'published' => true , 'description' => 'All Male from Afghanistan'),'resultId' => 1 , 'resultUrl' => $url1);
		//print_r(var_export($conditions1));
		
		//$c = 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}';
		//print_r(var_export(unserialize($c)));
		
		$conditions2 = array(array('infoid' => '4' , 'value' => '16-01-2010' , 'operator' => '='));
		$url2 = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid=2',false);
		$datas[] = array('info' => array('id' => 0 , 'owner' => 62 , 'name' => 'Register Date is 16-01-2010' , 'sortinfo' => 3 , 'sortdir' => 'ASC' , 'join' => 'AND' , 'conditions' => serialize($conditions2) , 'published' => true , 'description' => 'All members whose registeration date is 16 Jan 2010'),'resultId' => 2 , 'resultUrl' => $url2);
		
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			$result = $userController->_saveList(true,$data['info']);
			$this->assertEquals($data['resultId'],$result['id'],'info id during save should be '.$data['resultId'].' but we get '.$result['id']);
			$this->assertEquals($data['resultUrl'],$result['url'],'url shpuld be '.$data['resultUrl'].' but we get '.$result['url']);
		}
	}
	
	

	function testSaveExistUserlist()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'users.php'; 
		
		$userController = new XiusControllerUsers();
		
		$datas = array();
		$conditions1 = array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '='));
		$url1 = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid=1',false);
		$datas[] = array('info' => array('id' => 1 , 'owner' => 62 , 'name' => 'Male from Afghanistan' , 'sortinfo' => 8 , 'sortdir' => 'ASC' , 'join' => 'AND' , 'conditions' => serialize($conditions1) , 'published' => true , 'description' => 'All Male from Afghanistan'),'resultId' => 1 , 'resultUrl' => $url1);
		//print_r(var_export($conditions1));
		
		//$c = 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}';
		//print_r(var_export(unserialize($c)));
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			$result = $userController->_saveList(true,$data['info']);
			$this->assertEquals($data['resultId'],$result['id'],'info id during save should be '.$data['resultId'].' but we get '.$result['id']);
			$this->assertEquals($data['resultUrl'],$result['url'],'url shpuld be '.$data['resultUrl'].' but we get '.$result['url']);
		}
	}
}
?>