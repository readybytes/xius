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
		/*XITODO : provide join operator and sorting condition
		 * provide conditional operator also
		 * */
		$db = JFactory::getDBO();
		$query = new XiusQuery();
		
		if(empty($params))
			return $query;

		$cache = new XiusCache();
	
		$tableName = $cache->getTableName();
		
		if(!empty($tableName)) {
			$query->select('userid');
			$query->from($db->nameQuote($tableName));
			//$query->where(true,'AND');
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
	
	
	function getAllInfo($filter = '',$join = 'AND')
	{
		$info = XiusLibrariesInfo::getInfo($filter,$join);
		return $info;
	}
	
	
	function createTableQuery()
	{
		/*XITODO : pass info through parameter */
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
		
		$createQuery->finalizeQuery();
		
		return $createQuery->__toString();
	}
	
	
	function buildInsertUserdataQuery()
	{
		/*XITODO : pass info through parameter */
		$info = self::getAllInfo();
		
		if(empty($info))
			return false;

		$cache = new XiusCache();
		
		$query = new XiusQuery();
		
		foreach($info as $i){
			$instance = XiusFactory::getPluginInstanceFromId($i->id);
			$instance->getUserData($query);
		}
		
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		//$query->where('juser.`id` < 2000');
		
		return $query;
		
		$str = $query->__toString();
		/*XITODO : Bound result set starting from some users
		 * Limit should be configurable
		 */
		$str .= ' LIMIT 10';
		return $str;
		//return $query;
	}
	
	
	
	function insertUserData(XiusQuery $userInfo)
	{
		
		$table = new XiusCache();
		$tableName = $table->getTableName();

		$insertQuery = 'INSERT INTO `'.$tableName.'` ( ';
		$insertQuery .= $userInfo->__toString();
		$insertQuery .= ' )';
		
		$db =& JFactory::getDBO();
		$db->setQuery($insertQuery);
		if(!$db->query()) {
			$error = XiusFactory::getErrorObject();
			$error->setError($db->ErrorMsg());
			return false;
		}
		
		return true;
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
