<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusModelInfo extends XiusModel
{

	
	function __construct()
	{
		$this->_name  = 'info';
		$this->_table = '#__xius_info';

		// Call the parents constructor
		parent::__construct();
	}

	/*XITODO : Cache function for same filter */
	function getAllInfo($filter = '',$join = 'AND',$reqPagination = true,$limitStart=0 , $limit=0)
	{
		$allInfo = $this->loadRecords($filter, $join,$reqPagination, $limitStart, $limit);
		
		// trigger event after loading all info
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnAfterLoadAllInfo',array( &$allInfo ));
		
		return $allInfo;
	}

	function getInfo($id = 0)
	{
		$row = XiusFactory::getInstance ('info', 'table');
		$row->load($id);
		return $row;
	}

	
	function updatePublish($id,$value)
	{
		$this->updateRecord($id, "published", $value);
		return true;
	}
	
	
	function updateParams($id,$what,$value)
	{
		//XiTODO:: I think, its unusable checking
		if(!$what){
			return false;
		}
			
		$info = $this->getInfo($id);
		if(!$info){
			return false;
		}
			
		$params	= new XiusParameter('','');
		$params->bind($info->params);
		$params->set($what,$value);
		$paramStr = $params->toString('INI');
		//IMPT::$paramStr always pass as string
		$this->updateRecord($id, 'params', "'$paramStr'");		
		return true;
	}
}