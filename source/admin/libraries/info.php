<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusLibrariesInfo
{
	
	public function getInfo($filter = '',$join = 'AND',$reqPagination = false,$limitStart=0 , $limit=0)
	{
		$allInfo = self::getAllInfo();
		if(empty($filter) || count($allInfo) == 0)
			return $allInfo;
			
		foreach($filter as $fk => $fv){
			foreach($allInfo as $ak => $av){
				if($av->$fk != $fv)
					unset($allInfo[$ak]);
			}
		}
		
		$allInfo = array_values($allInfo);
		if($reqPagination == false)
			return $allInfo;
			
		$info = array();
		$count = 0;
		for($i=$limitStart ; $count < $limit ; $i++,$count++){
			$info[] = $allInfo[$i];
		}
		
		return $info;
	}
	
	
	/*public function getInfo($filter = '',$join = 'AND',$reqPagination = false,$limitStart=0 , $limit=0)
	{
		$iModel	= XiusFactory::getModel( 'info' );	
		$allInfo		=& $iModel->getAllInfo($filter,$join,$reqPagination,$limitStart, $limit);
		return $allInfo;
	}*/
	
	
	function getAllInfo($reset=false)
	{
		static $allInfo=null;
		if($reset == true){
			$allInfo=null;
			return $allInfo;
		}
			
		if( $allInfo != null && isset($allInfo))
			return $allInfo;
			
		$iModel	= XiusFactory::getModel( 'info' );	
		$allInfo	=& $iModel->getAllInfo('','AND',false);
		
		// trigger event after loading all info
		JPluginHelper::importPlugin('xius');
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnAfterLoadAllInfo',array( &$allInfo ));
		
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
