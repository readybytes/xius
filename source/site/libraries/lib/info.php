<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusLibInfo
{
	
	public static function getInfo($filter = '',$join = 'AND',$reqPagination = false,$limitStart=0 , $limit=0)
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
	
	
	public static function getAllInfo($reset=false)
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
	
}
