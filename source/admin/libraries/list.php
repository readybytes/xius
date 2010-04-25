<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesList
{	
	function saveList($data)
	{
		if(!isset($data['conditions']))
			return false;
			
		/*$listData['id'] 		= $data['id'];
		$listData['owner'] 		= $data['owner'];
		$listData['join'] 		= $data['join'];
		$listData['sortinfo'] 	= $data['sortinfo'];
		$listData['sortdir'] 	= $data['sortdir'];*/
		
		$lModel = XiusFactory::getModel('list','admin');
		
		//$id = $lModel->store($listData);
		$id = $lModel->store($data);
		if(!$id)
			return false;
		
		/*$lModel->removeConditions($id);
			
		$searchData = $data['searchdata'];
		
		if(!$searchData)
			return false;

		$condition = array();
		foreach($searchData as $sd){
			$condition['id'] 		= 0;
			$condition['listid'] 	= $id;
			$condition['infoid'] 	= $sd['infoid'];
			$condition['operator'] 	= $sd['operator'];
			$condition['value'] 	= serialize($sd['value']);
			
			$lModel->storeCondition($condition);
		}*/
		
		return $id;
	}	
}
