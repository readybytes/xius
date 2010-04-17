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
	
	
	function buildQuery($params,$join='AND',$sort='userid')
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
			$query->select($sort);
			$query->from($db->nameQuote($tableName));
			//$query->where(true,'AND');
		}
			
		foreach($params as $k => $v){
			/*XITODO : Pass operator */
			self::buildQueryForSingleInfo($query,$k,$v,'=',$join);
		}
		
		$strQuery = $query->__toString();
		
		if(empty($strQuery))
			return false;
			
		$strQuery .= 'SORT BY '.$db->nameQuote($sort); 
		
		/*XITODO : if unable to find any column
		 * then create table and retrive table
		 */
		return $strQuery;
		return $query->__toString();
		
	}
	
	
	function buildQueryForSingleInfo(XiusQuery &$query,$infoId,$value,$operator='=',$join='AND')
	{
		/*value can be array or single , depends on plugin 
		 * and we will store data only store data ( as value ) 
		 * only according to plugin , so they will get data as they want
		 */
		$instance = XiusFactory::getPluginInstanceFromId($infoId);
		return $instance->addSearchToQuery($query,$value,$operator,$join);
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
	
	
	function add_column($name, $specstr, $tname)
	{
		$db		=& JFactory::getDBO();
		$query	= 	'SHOW COLUMNS FROM ' 
					. $db->nameQuote($tname)
					. ' LIKE \'%'.$name.'%\' ';
		$db->setQuery( $query );
		$columns	= $db->loadObjectList();
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
			return false;
		}
	
		if($columns==NULL || $columns[0] == NULL)
		{
			$query =' ALTER TABLE '. $db->nameQuote($tname) 
					. ' ADD COLUMN ' . $db->nameQuote($name)
					. ' ' . $specstr;
			$db->setQuery( $query );
			$db->query();
			return true;
		}
		return false;
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
			if(is_array($i))
				$instance = XiusFactory::getPluginInstanceFromId($i['id']);
			else if(is_object($i))
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
	
	
	function updateCache()
	{
		$db =& JFactory::getDBO();
		/*XITODO : update xius_cache table with new info id
		 * We can only add column also without creating whole table
		 */
		/*First Drop table */
		$dropQuery = 'DROP TABLE IF EXISTS '.$db->nameQuote('#__xius_cache');
		$db->setQuery($dropQuery);
		if(!$db->query()) {
			$error = XiusFactory::getErrorObject();
			$error->setError($db->ErrorMsg());
			return false;
		}	
		
		$query = XiusLibrariesUserSearch::createTableQuery();
		$db->setQuery($query);
		if(!$db->query()) {
			$error = XiusFactory::getErrorObject();
			$error->setError($db->ErrorMsg());
			return false;
		}
		
		/*Add column */
		/*$instance = XiusFactory::getPluginInstanceFromId($data['id']);
		$columns = $instance->getCacheColumns();
		
		$cache = new XiusCache();
			
		if(empty($columns))
			return;
			
		foreach($columns as $c){
			XiusLibrariesUserSearch::add_column($c['columnname'],$c['specs'],$cache->_tableName);
		}
		
		$info = array();
		$info[0] = $data['data'];*/
		/*XITODO : break insert user data query into parts
		 * provide limit
		 */
		$getDataQuery = XiusLibrariesUserSearch::buildInsertUserdataQuery();
		
		$insertDataQuery = XiusLibrariesUserSearch::insertUserData($getDataQuery);
		$db->setQuery($insertDataQuery);
		
		if(!$db->query()) {
			$error = XiusFactory::getErrorObject();
			$error->setError($db->ErrorMsg());
			return false;
		}
	}
	
	
	
	function getMiniProfileDisplayFields($userid,$allInfo=array())
	{
		$displayFields = array();
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND');
		
		if(!empty($allInfo)){
			$count = 0;
			foreach($allInfo as $info){
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
				if($plgInstance->isVisible()){
					if($plgInstance->isAllRequirementSatisfy()){
						$displayFields[$info->labelName] = $plgInstance->getMiniProfileDisplay($userid,'#__xius_cache');
					}
				}
			}
		}
		
		return $displayFields;
	}
	
	
}
