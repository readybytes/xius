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
		
		return $id;
	}	
	
	
	function getUser()
	{
		
	}
}
