<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusLibrariesInfo
{
	
	public function getInfo($filter = '',$join = 'AND',$reqPagination = false,$limitStart=0 , $limit=0)
	{
		$iModel	= XiusFactory::getModel( 'info' );	
		$allInfo		=& $iModel->getAllInfo($filter,$join,$reqPagination,$limitStart, $limit);
		return $allInfo;
	}
	
	
	public function infoExist($data)
	{
		$filter = array();
		$filter['key'] = $data['key'];
		$filter['pluginType'] = $data['pluginType'];
		$info = self::getInfo($filter);
		if(empty($info))
			return false;
		
		return $info[0]->id;
	}
	
}
