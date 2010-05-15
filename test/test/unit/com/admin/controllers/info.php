<?php

class XiusControllerInfoTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testSaveNewInfo()
	{
		$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','pluginParams');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'info.php'; 
		
		JPluginHelper::importPlugin( 'system' , 'xius_system');
		
		$infoController = new XiusControllerInfo();
		
		$datas = array();
		$datas[] = array('info' => array('id' => 0 , 'pluginType' => 'Jsfields' , 'labelName' => 'Gender' , 'published' => true , 'key' => 2 , 'params' => array('isSearchable' => 1 , 'isVisible' => 1 , 'isSortable' => 0 , 'isExportable' => 0)),'resultId' => 1 , 'tableFieldName' => array('jsfields2'));
		$datas[] = array('info' => array('id' => 0 , 'pluginType' => 'Joomla' , 'labelName' => 'Name' , 'published' => true , 'key' => 'name' , 'params' => array('isSearchable' => 1 , 'isVisible' => 1 , 'isSortable' => 1 , 'isExportable' => 0)), 'resultId' => 2 , 'tableFieldName' => array('joomlaname'));
		
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			$result = $infoController->_processSave($data['info']);
			$this->assertEquals($data['resultId'],$result['id']);
			
			$alltFields = $db->getTableFields('#__xius_cache');
			$tFields = $alltFields['#__xius_cache'];
			
			//print_r(var_export($tFields));
			
			foreach($data['tableFieldName'] as $tname){
				$this->assertTrue(array_key_exists($tname,$tFields),"column $tname does not exist in cache table");
			}
		}
	}
	
	
	
	function testEditExistingInfo()
	{
		$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','pluginParams');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'info.php'; 
		
		JPluginHelper::importPlugin( 'system' , 'xius_system');
		
		$infoController = new XiusControllerInfo();
		
		$datas = array();
		$datas[] = array('info' => array('id' => 1 , 'pluginType' => 'Jsfields' , 'labelName' => 'All Gender' , 'published' => true , 'key' => 2 , 'params' => array('isSearchable' => 1 , 'isVisible' => 0 , 'isSortable' => 1 , 'isExportable' => 0)),'resultId' => 1 , 'tableFieldName' => array('jsfields2'));
		$datas[] = array('info' => array('id' => 2 , 'pluginType' => 'Jsfields' , 'labelName' => 'All City' , 'published' => false , 'key' => 11 , 'params' => array('isSearchable' => 1 , 'isVisible' => 1 , 'isSortable' => 1 , 'isExportable' => 0)), 'resultId' => 2 , 'tableFieldName' => array('jsfields11'));
		$datas[] = array('info' => array('id' => 4 , 'pluginType' => 'Joomla' , 'labelName' => 'Registeration Date' , 'published' => true , 'key' => 'registerDate' , 'params' => array('isSearchable' => 1 , 'isVisible' => 1 , 'isSortable' => 1 , 'isExportable' => 1)), 'resultId' => 4 , 'tableFieldName' => array('joomlaregisterDate'));
		
		$db = JFactory::getDBO();
		
		foreach($datas as $data){
			$result = $infoController->_processSave($data['info']);
			$this->assertEquals($data['resultId'],$result['id']);
			
			$alltFields = $db->getTableFields('#__xius_cache');
			$tFields = $alltFields['#__xius_cache'];
			
			//print_r(var_export($tFields));
			
			foreach($data['tableFieldName'] as $tname){
				$this->assertTrue(array_key_exists($tname,$tFields),"column $tname does not exist in cache table");
			}
		}
	}
	
	
	function testRemoveInfo()
	{
		$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','pluginParams');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'info.php'; 
		
		$infoController = new XiusControllerInfo();
		
		$delInfoIds = array(2,4,7);
		
		$db = JFactory::getDBO();
		
		$result = $infoController->_remove($delInfoIds);
		$this->assertTrue($result['success']);		
	}
	
	
	function testSaveParams()
	{
		$this->_DBO->addTable('#__xius_info');
		$this->_DBO->filterColumn('#__xius_info','pluginParams');
		
		$this->resetCachedData();
		
		require_once XIUS_COMPONENT_PATH_ADMIN.DS.'controllers'.DS.'info.php'; 
		
		$infoController = new XiusControllerInfo();
		
		$datas[]= array('infoid' => 1 , 'subtask' => 'unsortable','result' => true);
		$datas[]= array('infoid' => 6 , 'subtask' => 'sortable','result' => true);
		$datas[]= array('infoid' => 1 , 'subtask' => 'invisible','result' => true);
		$datas[]= array('infoid' => 2 , 'subtask' => 'unexportable','result' => true);
		$datas[]= array('infoid' => 6 , 'subtask' => 'exportable','result' => true);
		$datas[]= array('infoid' => 3 , 'subtask' => 'visible','result' => true);
		$datas[]= array('infoid' => 4 , 'subtask' => 'searchable','result' => true);
		$datas[]= array('infoid' => 8 , 'subtask' => 'unsearchable','result' => true);
		$datas[]= array('infoid' => 7 , 'subtask' => 'searchable','result' => true);
		

		foreach($datas as $data){
			$result = $infoController->_saveParamDoable($data['infoid'],$data['subtask']);
			$this->assertEquals($data['result'],$result);
		}
	}
	
}
?>
