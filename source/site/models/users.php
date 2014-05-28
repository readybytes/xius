<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusModelUsers extends XiusModel
{
	protected $_users = null;

	function __construct()
	{
		// set table name for query
		$this->_table = '#__xius_cache';
        parent::__construct();
	}
	
	/**
	 * return all users according to Params (Search conditions) 
	 * @param $params is condition
	 * @param $join: Match conditon
	 * @param $sort: sort condition
	 * @param $dir : direction
	 * @param $reqPagination
	 */
	function getUsers($params,$join='AND',$sort='userid',$dir='ASC',$reqPagination=true)
	{
		if(isset($this->_users)){
			return $this->_users;
		}

		// @param is condition. limitsatart and limit have 0 value 
		$this->_users = $this->loadRecords($params,$join,$reqPagination, 0, 0, $sort, $dir);  

        // XiusError::assert($this->_db->_cursor,'cache table does not exist. Creating it ');
        return $this->_users;
  	}

	/**
	 * return (string)query
	 * @param unknown_type $params
	 * @param unknown_type $join
	 * @param unknown_type $sort
	 * @param unknown_type $dir
	 * @return XiusQuery 
	 */
	function getQuery($params='',$join='AND', $reset=true, $sort='userid', $dir='ASC')
	{
		/*XITODO:  provide conditional operator also
		*/		
		if(isset($this->_query) && $reset==false){
			return $this->_query;
		}
		//query initialize
		$this->_query = new XiusQuery();
		$tableName = $this->getTable();	
		
		XiusError::assert($tableName,"NO TABLE TO SEARCH");

		// convert into database formate, table name and column
		$sort = $this->_db->quoteName($sort);
		$tableName = $this->_db->quoteName($tableName);
			
		//Build Query
		$this->_query->select('*')
			  		 ->from($tableName);
		/*if no parameter to search then return all users
		 * without any condition
		 * XITODO : add block condition
		 */
		if(!empty($params)){
			$this->_buildQuery($this->_query, $params, $join);
		}	

		$this->_query->order($sort.' '.$dir);
		/*Trigger event */
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onAfterSearchQuery', array( &$this->_query, $sort, $dir ) );

		return $this->_query;
	}
	
	/**
	 * build query according condition (params)
	 * @param XiusQuery $query
	 * @param unknown_type $params: Search condition
	 * @param unknown_type $join: match condition
	 */
	function _buildQuery(XiusQuery &$query, $params, $join)
	{
		/* value can be array or single , depends on plugin 
		*  and we will store data only store data ( as value ) 
		* only according to plugin , so they will get data as they want
		*/
		foreach($params as $p){
			$instance = XiusFactory::getPluginInstance('',$p['infoid']);
			if(!$instance){
				continue;
			}
			$instance->addSearchToQuery($query,$p['value'],$p['operator'],$join);
		}
	}
}
