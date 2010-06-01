<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
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
	
	function getLists($filter='', $join = 'AND',$reqPagination=true)
	{		
		$lModel = XiusFactory::getModel('list','admin');
		return $lModel->getLists($filter, $join, $reqPagination);
			
	}
}
