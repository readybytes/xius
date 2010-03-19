<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesUserSearch
{
	
	function getUsers()
	{
		
	}
	
	
	function buildQuery($params)
	{
		$db = JFactory::getDBO();
		$query = new XiusQuery();
		
		if(empty($params))
			return $query;

		$cache = new XiusCache();
	
		$tableName = $cache->getTableName();
		
		if(!empty($tableName)) {
			$query->select('userid');
			$query->from($db->nameQuote($tableName));
		}
			
		foreach($params as $k => $v){
			self::buildQueryForSingleInfo($query,$k,$v);
		}
		
		return $query->__toString();
		
	}
	
	
	function buildQueryForSingleInfo(XiusQuery &$query,$infoId,$value)
	{
		/*value can be array or single , depends on plugin 
		 * and we will store data only store data ( as value ) 
		 * only according to plugin , so they will get data as they want
		 */
		$instance = XiusFactory::getPluginInstanceFromId($infoId);
		return $instance->addSearchToQuery($query,$value);
	}
	
	
	function collectParamstoSearch()
	{
		
	}
	
	
	function getAllInfo()
	{
		$info = XiusLibrariesInfo::getInfo();
		return $info;
	}
	
	
	function createTableQuery()
	{
		$info = self::getAllInfo();
		
		if(empty($info))
			return false;

		$cache = new XiusCache();
		$createQuery = new XiusCreateTable($cache->_tableName);
			
		if(false == $createQuery)
			return false;
			
		foreach($info as $i){
			$instance = XiusFactory::getPluginInstanceFromId($i->id);
			$instance->appendCreateQuery($createQuery);
		}
		
		return $createQuery->__toString();
	}
	
	
	function getMembersCount($listid)
	{
		$lModel = JSULFactory::getModel('List');
		$totalUsers = $lModel->getMembersCount($listid);
		return $totalUsers;
	}
	
	function getListMembers($listid, $limitStart, $limit, $sortBy, $sortDir)
	{
		$cusers = array();
		$lModel = JSULFactory::getModel('List');
		$result = $lModel->getListMembers($listid, $limit, $limitStart, $sortBy, $sortDir);
		// return only limited members
		foreach($result as $r)
		{			
			$cusers[]  =& CFactory::getUser($r->id );
		}	
				
		return 	$cusers;
	}

	
}