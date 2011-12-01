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
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'list.php'; 
		
		$userController = new XiussiteControllerList();
		$user = & JFactory::getUser(62);
		$datas = array();
		$url1 = array('listid'=>1,'task'=>'showList','view'=>'list');
		$datas[] = array('info' => array('listid' => 0 , 'xiusListName' => 'Male from Afghanistan' , 'xiusListSortInfo' => 4 , 'xiusListSortDir' => 'DESC' , 'xiusListJoinWith' => 'AND' ,'params' => Array('js_privacy' => 'public'), 'xiusListPublish' => true , 'xiusListDesc' => 'All Male from Afghanistan'),'resultId' => 1 , 'resultUrl' => $url1,
					'conditions' => array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '=')));
		//print_r(var_export($conditions1));
		
		//$c = 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}';
		//print_r(var_export(unserialize($c)));

		$url2 = array('listid'=>2,'task'=>'showList','view'=>'list');		
		$datas[] = array('info' => array('listid' => 0 , 'xiusListName' => 'Register Date is 16-01-2010' , 'xiusListSortInfo' => 3 , 'xiusListSortDir' => 'ASC' , 'xiusListJoinWith' => 'AND' , 'params' => Array('js_privacy' => 'public'), 'xiusListPublish' => true , 'xiusListDesc' => 'All members whose registeration date is 16 Jan 2010'),'resultId' => 2 , 'resultUrl' => $url2,
					'conditions' => array(array('infoid' => '4' , 'value' => '16-01-2010' , 'operator' => '=')));
		
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$data['conditions']);
			$result = $userController->_saveList('true',$data['info'],null,$user);
			$this->assertEquals($data['resultId'],$result['id'],'info id during save should be '.$data['resultId'].' but we get '.$result['id']);
			$this->matchUrls($data['resultUrl'],$result['url']);
		}
	}
	
	function matchUrls($data,$result)
	{		
		$resultURI 	= new JURI($result);		
		$resultVar 	= $resultURI->getQuery(true);

		foreach($data as $key=> $value){
			if(array_key_exists($key, $resultVar)){
				if($value != $resultVar[$key])
					return true;
			}
		}
	}

	function testSaveExistUserlist()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'list.php'; 
		
		$userController = new XiussiteControllerList();
		$datas = array();
		$url1 = array('listid'=>1,'task'=>'showList','view'=>'list');		
		$datas[] = array('info' => array('listid' => 1 , 'xiusListName' => 'Male from Afghanistan' , 'xiusListSortInfo' => 8 , 'xiusListSortDir' => 'ASC' , 'xiusListJoinWith' => 'AND' ,'params' => Array('js_privacy' => 'public'), 'xiusListPublish' => true , 'xiusListDesc' => 'All Male from Afghanistan'),'resultId' => 1 , 'resultUrl' => $url1,
						'conditions' => array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '=')));
		//print_r(var_export($conditions1));
		
		//$c = 'a:2:{i:0;a:3:{s:6:"infoid";s:1:"1";s:5:"value";s:4:"Male";s:8:"operator";s:1:"=";}i:1;a:3:{s:6:"infoid";s:1:"3";s:5:"value";s:11:"Afghanistan";s:8:"operator";s:1:"=";}}';
		//print_r(var_export(unserialize($c)));
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$data['conditions']);
			$result = $userController->_saveList('false',$data['info'],null,JFactory::getUser(62));
			$this->assertEquals($data['resultId'],$result['id'],'info id during save should be '.$data['resultId'].' but we get '.$result['id']);
			$this->matchUrls($data['resultUrl'],$result['url']);
		}
	}
	
	function testSaveListWithPrivacy()
	{
		$this->_DBO->addTable('#__xius_list');		
		$this->_DBO->filterColumn('#__xius_list','ordering');
		JPluginHelper::importPlugin( 'xius' );	
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'list.php'; 
		
		$userController = new XiussiteControllerList();
		
		$datas = array();
		$url1 = array('listid'=>1,'task'=>'showList','view'=>'list');		
		$datas[] = array('info' => array('listid' => 1, 'xiusListName' => 'Male from Afghanistan' , 'xiusListSortInfo' => 8 , 'xiusListSortDir' => 'ASC' , 'xiusListJoinWith' => 'AND', 'params' => Array('js_privacy' => 'member'), 'xiusListPublish' => true , 'xiusListDesc' => 'All Male from Afghanistan','js_privacy' => 'member'),'resultId' => 1 , 'resultUrl' => $url1,
						'conditions' => array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '=')));
	
		$list	= JTable::getInstance( 'list' , 'XiusTable' );
		$list->load(1);
		$config = new JRegistry('xiuslist');
		$config->loadINI($list->params);
		$params = $config->toArray('xiuslist');
		
		foreach($datas as $data){
			XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$data['conditions']);
			$result = $userController->_saveList('false',$data['info'],$params,JFactory::getUser(62));
			$this->assertEquals($data['resultId'],$result['id'],'info id during save should be '.$data['resultId'].' but we get '.$result['id']);
			$this->matchUrls($data['resultUrl'],$result['url']);
		}		
	}
	
	function testSaveListWithPrivacyNew()
	{
		$this->_DBO->addTable('#__xius_list');		
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_SITE.DS.'controllers'.DS.'list.php';
		$url1 = array('listid'=>3,'task'=>'showList','view'=>'list');		
		// save as new list
		$this->resetCachedData();
		unset($post);
		$params=null;		
		$conditions = array(array('infoid' => '1' , 'value' => 'Male' , 'operator' => '='),array('infoid' => '3' , 'value' => 'Afghanistan' , 'operator' => '='));
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions);
		$user =& JFactory::getUser(62);
		
		$post['listid']				=	0;
		$post['xiusListName']		= "Male Users";
		$post['xiusListDesc']		= 'Show Male Users';
		$post['xiusListPublish']	= 1;
		$post['xiusListJoinWith']	= 'OR';
		$post['xiusListSortInfo']	= 2;
		$post['xiusListSortDir']	= 'DESC';
		$post['params']['js_privacy'] 		= 'friend';
		
		$userController1 = new XiussiteControllerList();
		$result = $userController1->_saveList(true,$post,null,$user);
		$this->assertEquals(3,$result['id'],'info id during save should be 3 but we get '.$result['id']);
		$this->matchUrls($url1,$result['url']);
	}
	
	function testSaveListChecks()
	{
		$unsuccess	 = array('id' => 0,
							'url' => JRoute::_('index.php?option=com_xius&view=users',false),
							'msg' => 'You can not save list',
							'success' => false,
							);

		$success	= array('id' => 0,
  							'success' => true,
							);
		
		$user = & JFactory::getUser(62);
		$user->usertype = "Administrator";
		$user->gid      = 24;
		$userController = new XiussiteControllerList();
		$returnData		= $userController->_saveListChecks(true,$user);
		$this->assertEquals($returnData , $success);
		
		// if user type is manager, must be succeed
		$user->usertype = "Manager";
		$user->gid      = 23;
		$returnData		= $userController->_saveListChecks(true,$user);
		$this->assertEquals($returnData , $success);
		
		// if user type is super administrator, must be succeed
		$user->usertype = "Super Administrator";
		$user->gid      = 25;
		$returnData		= $userController->_saveListChecks(true,$user);
		$this->assertEquals($returnData , $success);
		
	}
}
?>