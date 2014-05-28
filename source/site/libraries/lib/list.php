<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibList
{	
	public static function saveList($data)
	{
		if(!isset($data['conditions']))
			return false;
		
		//return id
		return XiusFactory::getInstance ('list', 'model')
						  ->store($data);
	}	

	/**
	 * get all lists with filteration
	 * @param $filter
	 * @param $join
	 * @param $reqPagination
	 */
	public static function getLists($filter='', $join = 'AND',$reqPagination=true)
	{		
		return XiusFactory::getInstance ('list','model')
		 				  ->getLists($filter, $join, $reqPagination);
			
	}

	/**
	 * get list according list id
	 * @param unknown_type $id
	 */
	public static function getList($id = 0)
	{
		if($id === 0){
			return false;
		}

		$filter	= array('id'=>$id);
		$row	= self::getLists($filter,'AND',false);

		if(empty($row)){
			return false;
		}
			
		return $row[0];
	}
}
