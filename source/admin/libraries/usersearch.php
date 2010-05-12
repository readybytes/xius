<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');


class XiusLibrariesUsersearch
{	
	function buildQuery($params,$join='AND',$sort='userid',$dir='ASC')
	{
		/*XITODO : provide join operator and sorting condition
		 * provide conditional operator also
		 * provide direction also
		 * */
		/*Trigger event */
		$dispatcher =& JDispatcher::getInstance();
		$data = array();
		$data['conditions'] = &$params;
		$data['join'] = &$join;
		$data['sort'] = &$sort;
		$data['dir']  = &$dir;
		$results = $dispatcher->trigger( 'onBeforeUserSearchQueryBuild', array( $data ) );
		
		$db = JFactory::getDBO();
		$query = new XiusQuery();		
		$cache = XiusFactory::getCacheObject();
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
		//$dispatcher =& JDispatcher::getInstance();
		$results = $dispatcher->trigger( 'onAfterUserSearchQueryBuild', array( &$query ) );
		
	/*	$strQuery = $query->__toString();
		
		if(empty($strQuery))
			return false;*/
				
		return $query;
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
	
	
	function setDataInSession($what,$value,$namespace='XIUS')
	{
		$mySess =& JFactory::getSession();
		$mySess->set($what,$value,$namespace);
		return true;
	}
	
	
	function getDataFromSession($what,$default=false,$namespace='XIUS')
	{
		$mySess =& JFactory::getSession();
		$params = $mySess->get($what,$default,$namespace);
		
		return $params;
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
		$info = self::getAllInfo();
		$cache = XiusFactory::getCacheObject();
		return $cache->buildCreateTableQuery($info);
	}
	
	
	function buildInsertUserdataQuery()
	{
		/*XITODO : pass info through parameter */
		$info = self::getAllInfo();
		
		if(empty($info))
			return false;

		$query = new XiusQuery();
		
		/*This should always be on top
		 * else joomlausername data will be added first
		 * and it will overrite userid
		 */
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		//$query->where('juser.`id` < 2000');
		
		foreach($info as $i){
			if(is_array($i))
				$instance = XiusFactory::getPluginInstanceFromId($i['id']);
			else if(is_object($i))
				$instance = XiusFactory::getPluginInstanceFromId($i->id);
				
			if(!$instance)
				continue;
				
			$instance->getUserData($query);
		}
		
		return $query;
	}
	
	
	
	function insertUserData(XiusQuery $userInfo)
	{
		$cache = XiusFactory::getCacheObject();
		return $cache->insertIntoTable($userInfo);
	}
	
	
	function updateCache()
	{
		$db =& JFactory::getDBO();
		/*XITODO : update xius_cache table with new info id
		 * We can only add column also without creating whole table
		 */
		$cache = XiusFactory::getCacheObject();
		if(!$cache->createTable(true))
			return false;

		/*XITODO : break insert user data query into parts
		 * provide limit , for huge amount of users say 1,00,000
		 * then in first rount process 1000 users then again 1000 etc.
		 */
		$getDataQuery = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		
		return $cache->insertIntoTable($getDataQuery);
	}
	
	
	
	function getMiniProfileDisplayFields($userid,$allInfo=null)
	{
		/*XITODO : pass info
		 * for admin display all fields , discard publish checking
		 */
		$displayFields = array();
		
		if($allInfo == null){
			$filter = array();
			$filter['published'] = true;
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND');
		}
		if(empty($allInfo))
			return $displayFields;
			
		$count = 0;
		$cache = XiusFactory::getCacheObject();
		foreach($allInfo as $info){
			$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
			
			if(!$plgInstance)
				continue;
				
			$plgInstance->bind($info);			
				
			if(!$plgInstance->isAllRequirementSatisfy())
				continue;
				
			if(!$plgInstance->isVisible())
				continue;
					
			$displayFields[$info->labelName] = $plgInstance->getMiniProfileDisplay($userid,$cache->getTableName());
		}
		
		return $displayFields;
	}
	
	
	function getSortableFields($allInfo=null)
	{
		/*XITODO : pass info
		 * for admin display all fields , discard publish checking
		 */
		$sortableFields = array();
		if($allInfo == null){
			$filter = array();
			$filter['published'] = true;
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND');
		}
		
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
	
	
	function processUserRequest($what)
	{
		
		switch($what){
			case 'SEARCH':
				return XiusLibrariesUsersearch::processSearch();
				break;

			case 'DELINFO':
				return XiusLibrariesUsersearch::deleteSearchData();
				break;
				
			case 'SORT':
				return XiusLibrariesUsersearch::processSort();
				break;
		}
			
	}
	
	
	
	function processSearchData($post=null)
	{
		if($post==null)
			$post = JRequest::get('POST');
			
		$searchdata = array();
		$infoid = 0;
		foreach($post as $key => $value){
			if(JString::stristr($key,'xiusinfo_')){
				if($infoid && $infoid == $value)
					$infoid = 0;
				else
					$infoid = $value;
				
				continue;
			}
			
			if(empty($value))
				continue;
			
			if($infoid){
				$data = array();
				$data['infoid'] = $infoid;
				$data['value'] = $value;
				$data['operator'] = XIUS_EQUAL;
				
				array_push($searchdata,$data);
			}

		}	
		
		return $searchdata;
	}
	
	
	function deleteSearchData()
	{
		/*XITODO : only delete same infoid verses value pair
		 * don't delete all infoid
		 */
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		
		if(!$conditions)
			return true;
		
		$delInfoId = JRequest::getVar('xiusdelinfo', 0, 'POST');
		
		if(!$delInfoId)
			return true;
		
		$conditionvalue = JRequest::getVar('conditionvalue', '', 'POST');
		$value = unserialize($conditionvalue);
		$conditions = array_values($conditions);

		$searchdata['infoid'] = $delInfoId;
		$searchdata['value'] = $value;
		$searchdata['operator'] = XIUS_EQUAL;
			
		$position = XiusLibrariesUsersearch::checkSearchDataExistance($searchdata,$conditions);
		if($position)
			unset($conditions[$position-1]);
			
		$conditions = array_values($conditions);
	       
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		return true;
	}
	
	
	function addSearchData()
	{
		$addInfoId = JRequest::getCmd('xiusaddinfo',0);
		
		if(!$addInfoId)
			return;
			
		$post = JRequest::get('POST');
		
		if(!$post)
			return;
			
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		if(!$conditions)
			$conditions = array();

		$conditions = array_values($conditions);

		$start = false;
		$infoid = 0;
		foreach($post as $key => $value){
			if(JString::stristr($key,'xiusinfo_')){
				if($addInfoId && $value == $infoid && $start)
					$start = false;
				if($addInfoId == $value && !$infoid){
					$start = true;
					$infoid = $addInfoId;
				}
				
				continue;
			}
			
			if(empty($value))
				continue;
			
			if($start){
				$searchdata['infoid'] = $addInfoId;
				$searchdata['value'] = $value;
				$searchdata['operator'] = XIUS_EQUAL;
				
				$result = XiusLibrariesUsersearch::checkSearchDataExistance($searchdata,$conditions);
				if(!$result)
					array_push($conditions,$searchdata);
				
				$start = false;
				$conditions = array_values($conditions);
				XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
				return;
			}
		}
	}
	
	/*$searchArray :- Required to check 
	 * $inArray :- check existance of searchArray in inArray
	 */
	function checkSearchDataExistance(array $searchArray,array $inArray)
	{
		if(empty($searchArray) || empty($inArray))
			return false;

		$count = 0; 
		foreach($inArray as $k => $i){
			
			$count++;
			
			if($i['infoid'] != $searchArray['infoid'])
				continue;
				
			if($i['operator'] != $searchArray['operator'])
				continue;
				
			if(is_array($searchArray['value'])){
				if(!is_array($i['value']))
					continue;
					
				$extraValueInsearch = array_diff($searchArray['value'],$i['value']);
				$extraValueInI = array_diff($i['value'],$searchArray['value']);
					
				if($extraValueInsearch || $extraValueInI)
					continue;
				
				if(!$extraValueInI && !$extraValueInI)
					return $count;
			}
			else {
				if(is_array($i['value']))
					continue;
					
				if($i['value'] == $searchArray['value'])
					return $count;
			}
			
		}
		
		return false;
	}
	
	
	function processSortData()
	{
		$sort = JRequest::getVar('xiussort', 'userid', 'POST');
		$dir = JRequest::getVar('xiussortdir', 'ASC', 'POST');
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_SORT,$sort,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_DIR,$dir,'XIUS');
	}
}
