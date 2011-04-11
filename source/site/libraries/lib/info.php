<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusLibInfo
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
	
	
	function getAllInfo($reset=false)
	{
		static $allInfo=null;
		if($reset == true){
			$allInfo=null;
			return $allInfo;
		}
			
		if( $allInfo != null && isset($allInfo))
			return $allInfo;
			
		$iModel	 = XiusFactory::getInstance ( 'info', 'model' );	
		$allInfo = $iModel->getAllInfo('','AND',false);
		
		return $allInfo;
	}
	
	// XITODO: Remove this, its unusable
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