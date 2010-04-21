<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesUsersearch
{
	
	function getUsers()
	{
		
	}
	
	
	function buildQuery($params,$join='AND',$sort='userid',$dir='ASC')
	{
		/*XITODO : provide join operator and sorting condition
		 * provide conditional operator also
		 * provide direction also
		 * */
		$db = JFactory::getDBO();
		$query = new XiusQuery();
		
		$cache = new XiusCache();
	
		$tableName = $cache->getTableName();
		
		if(empty($tableName))
			JError::raiseError(JText::_('NO TABLE TO SEARCH'));
			
		if(!empty($tableName)) {
			//$query->select($db->nameQuote('userid'));
			$query->select('*');
			$query->from($db->nameQuote($tableName));
		}
		
		/*if no parameter to search then return all users
		 * without any condition
		 * XITODO : add block condition
		 *  */
		if(empty($params))
			$query->order($db->nameQuote($sort).' '.$dir);
		else{
			foreach($params as $p)
				self::buildQueryForSingleInfo($query,$p['infoid'],$p['value'],$p['operator'],$join);
			
			$query->order($db->nameQuote($sort).' '.$dir);
		}
		
		/*Trigger event */
		$dispatcher =& JDispatcher::getInstance();
		$results = $dispatcher->trigger( 'onAfterUserSearchQueryBuild', array( &$query ) );
		
		$strQuery = $query->__toString();
		
		if(empty($strQuery))
			return false;
				
		return $strQuery;
	}
	
	
	function buildQueryForSingleInfo(XiusQuery &$query,$infoId,$value,$operator=XIUS_EQUAL,$join='AND')
	{
		/*value can be array or single , depends on plugin 
		 * and we will store data only store data ( as value ) 
		 * only according to plugin , so they will get data as they want
		 */
		$instance = XiusFactory::getPluginInstanceFromId($infoId);
		
		if(!$instance)
			return;
			
		return $instance->addSearchToQuery($query,$value,$operator,$join);
	}
	
	
	function collectParamstoSearch()
	{
		$mySess =& JFactory::getSession();
		$searchdata = $mySess->get('searchdata',false,'XIUS');
		
		return $searchdata;
	}
	
	
	function collectSortParams()
	{
		$mySess =& JFactory::getSession();
		$sortInfo = array();
		$sortInfo['sort'] = $mySess->get('sort',false,'XIUS');
		$sortInfo['dir'] = $mySess->get('dir',false,'XIUS');
		
		return $sortInfo;
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

		/*XITODO : move create table query code to cache class*/
		$cache = new XiusCache();
		$createQuery = new XiusCreateTable($cache->_tableName);
			
		if(false == $createQuery)
			return false;
			
		foreach($info as $i){
			$instance = XiusFactory::getPluginInstanceFromId($i->id);
			if(!$instance)
				continue;
				
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
				
			if(!$instance)
				continue;
				
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
		
		$query = XiusLibrariesUsersearch::createTableQuery();
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
		/*XITODO : pass info
		 * for admin display all fields , discard publish checking
		 */
		$displayFields = array();
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND');
		
		if(empty($allInfo))
			return $displayFields;
			
		$count = 0;
		foreach($allInfo as $info){
			$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
			
			if(!$plgInstance)
				continue;
				
			if(!$plgInstance->isAllRequirementSatisfy())
				continue;
				
			if(!$plgInstance->isVisible())
				continue;
					
			$displayFields[$info->labelName] = $plgInstance->getMiniProfileDisplay($userid,'#__xius_cache');
		}
		
		return $displayFields;
	}
	
	
	function getSortableFields($allInfo=array())
	{
		/*XITODO : pass info
		 * for admin display all fields , discard publish checking
		 */
		$sortableFields = array();
		/*$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND');*/
		
		if(empty($allInfo))
			return $sortableFields;
		$count = 0;
		foreach($allInfo as $info){
			$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
			
			if(!$plgInstance)
				continue;
				
			if(!$plgInstance->isAllRequirementSatisfy())
				continue;
				
			if(!$plgInstance->isSortable())
				continue;
				
			$sortableFields[$count] = $plgInstance->renderSortableHtml();
					
			$count++;
		}
		
		return $sortableFields;
	}
	
	
}
