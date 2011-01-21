<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibList
{	
	function saveList($data)
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
	function getLists($filter='', $join = 'AND',$reqPagination=true)
	{		
		return XiusFactory::getInstance ('list','model')
		 				  ->getLists($filter, $join, $reqPagination);
			
	}

	/**
	 * get list according list id
	 * @param unknown_type $id
	 */
	function getList($id = 0)
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
