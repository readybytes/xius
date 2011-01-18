<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class XiusLibUsersearch
{	
	function buildQuery($params,$join='AND',$sort='userid',$dir='ASC')
	{
		return XiusModelUsers::getQuery($params,$join,$sort,$dir);
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
		$info = XiusLibInfo::getInfo($filter,$join);
		return $info;
	}
	
	function buildInsertUserdataQuery()
	{
		/*XITODO : pass info through parameter */
		$info = self::getAllInfo();
		
		if(empty($info))
			return false;
		// sorting thr info according to their dependent info
		// so that the current info query will be created after their dependent info
		$info  = XiusHelperUsersearch::getSortedInfo($info);
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
				$instance = XiusFactory::getPluginInstance('',$i['id']);
			else if(is_object($i)){
				 $instance = XiusFactory::getPluginInstance('',$i->id);
			}

			if(!$instance)
				continue;
				
			$instance->getUserData($query);
		}
		
		return $query;
	}
	
	
	
	function insertUserData(XiusQuery $userInfo)
	{
		$cache = XiusFactory::getInstance('cache');
		return $cache->insertIntoTable($userInfo);
	}
	
	
	function updateCache()
	{		
		/*XITODO : update xius_cache table with new info id
		 * We can only add column also without creating whole table
		 */
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeXiusCacheUpdate' );
		
		// Set session variable thaht use in privacy plugings.
		// Check: Not any information unset during cache update 
		JFactory::getSession()->set('updateCache', true);
		
		$cache = XiusFactory::getInstance('cache');
		if(!$cache->createTable()){
			return false;
		}
			
		/*XITODO : break insert user data query into parts
		 * provide limit , for huge amount of users say 1,00,000
		 * then in first rount process 1000 users then again 1000 etc.
		 */
		$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
		
		$result =  $cache->insertIntoTable($getDataQuery);
		
		// Unset session variable
		JFactory::getSession()->clear('updateCache', true);
		
		// trigger the event onAfterXiusCacheUpdate		
		$dispatcher->trigger( 'onAfterXiusCacheUpdate' );
		return $result;
	}
	
	
	function getTimestamp()
	{
		$time = time();
		return $time;
	}
	
	
	function saveCacheParams($what,$value)
	{		
		$config	=& JTable::getInstance( 'configuration' , 'XiusTable' );
		$config->load( 'cache' );
		
		$cModel = XiusFactory::getInstance ('configuration', 'model');
		
		$params = $cModel->getOtherParams('cache');
		$params->set($what,$value);
		
		$config->params = $params->toString('INI');
		
		$config->store();
		
	}
	
	
	
	function getMiniProfileDisplayFields($userid,$allInfo=null)
	{
		/*XITODO : pass info
		 * for admin display all fields , discard publish checking
		 */
		$displayFields = array();
		
		if($allInfo == null){
			$filter = array();
			$user =& JFactory::getUser();
			if(!XiusHelperUtils::isAdmin($user->id))
					$filter['published'] = true;
			$allInfo = XiusLibInfo::getInfo($filter,'AND');
		}
		if(empty($allInfo))
			return $displayFields;
			
		$cache = XiusFactory::getInstance('cache');
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
			$user =& JFactory::getUser();
			if(!XiusHelperUtils::isAdmin($user->id))
					$filter['published'] = true;
			$allInfo = XiusLibInfo::getInfo($filter,'AND');
		}
		
		if(empty($allInfo))
			return $sortableFields;
			
		$count = 0;
		foreach($allInfo as $info){
			$plgInstance = XiusFactory::getPluginInstance('',$info->id);
			
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
	
	
	/*function processUserRequest($what)
	{
		
		switch($what){
			case 'SEARCH':
				return XiusLibUsersearch::processSearch();
				break;

			case 'DELINFO':
				return XiusLibUsersearch::deleteSearchData();
				break;
				
			case 'SORT':
				return XiusLibUsersearch::processSort();
				break;
		}
		
		return false;
			
	}*/
	
	function processSearchData($post=null)
	{
		if($post==null)
			$post = JRequest::get('POST');
		
		$data = array();
		$searchdata = array();
		$infoid = 0;
		$keyNames = array_keys($post);
		
		$count = count($keyNames);
		for( $i=0 ; $i < $count ; $i++){
			if(JString::stristr($keyNames[$i],'xiusinfo_')){
				if($infoid && $infoid == $post[$keyNames[$i]])
					$infoid = 0;
				else
					$infoid = $post[$keyNames[$i]];
				
				continue;
			}
			
			if(empty($post[$keyNames[$i]]) && !is_numeric($post[$keyNames[$i]]))
				continue;
			
			if(!$infoid)
				continue;
				
			$data = array();
			$data['infoid'] = $infoid;
			
			if(JString::stristr($keyNames[$i+1],'xiusinfo_'))
				$data['value'] = XiusHelperUsersearch::trimWhiteSpace($post[$keyNames[$i]]);
			else{
				while(!JString::stristr($keyNames[$i],'xiusinfo_')){
					$data['value'][] = XiusHelperUsersearch::trimWhiteSpace($post[$keyNames[$i]]);
					$i++;
				}
				$i--;
			}
				
			$data['operator'] = XIUS_EQUAL;
			
			array_push($searchdata,$data);		
		}		
		return $searchdata;
	}
	
	
	function deleteSearchData($conditions = null,$delInfoId = null,$conditionvalue = null)
	{
		/*XITODO : only delete same infoid verses value pair
		 * don't delete all infoid
		 */
		if($conditions == null)
			$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		
		if(!$conditions)
			return false;
	
		if($delInfoId == null)
			$delInfoId = JRequest::getVar('xiusdelinfo', 0, 'POST');
		
		if(!$delInfoId)
			return false;
		
		if($conditionvalue == null)
			$conditionvalue = JRequest::getVar('conditionvalue', '', 'POST');
			
		$value = XiusHelperUsers::getUnserializedData($conditionvalue);
		$conditions = array_values($conditions);
		
		$searchdata['infoid'] = $delInfoId;
		$searchdata['value'] = $value;
		$searchdata['operator'] = XIUS_EQUAL;
		
		$position = XiusLibUsersearch::checkSearchDataExistance($searchdata,$conditions);
		if($position)
			unset($conditions[$position-1]);
			
		$conditions = array_values($conditions);
	       
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		return true;
	}
	
	
	function addSearchData($addInfoId = null,$post = null)
	{
		if($addInfoId == null)
			$addInfoId = JRequest::getCmd('xiusaddinfo',0);
		
		if(!$addInfoId)
			return;
			
		if($post == null)
			$post = JRequest::get('POST');
		
		if(!$post)
			return;
			
		$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		if(!$conditions)
			$conditions = array();

		$conditions = array_values($conditions);

		$start = false;
		$infoid = 0;
		
		$keyNames = array_keys($post);
		//XiTODO:: invoke count only one time
		for( $i=0 ; $i < count($keyNames) ; $i++){		
			if(JString::stristr($keyNames[$i],'xiusinfo_')){
				if($addInfoId && $post[$keyNames[$i]] == $infoid && $start)
					$start = false;
				if($addInfoId == $post[$keyNames[$i]] && !$infoid){
					$start = true;
					$infoid = $addInfoId;
				}
				
				continue;
			}
			// XITODO : test with 0,null,baln,blank array
			if(empty($post[$keyNames[$i]]) && !is_numeric($post[$keyNames[$i]]))
				continue;
			
			if($start){
				$searchdata['infoid'] = $addInfoId;
				
				if(JString::stristr($keyNames[$i+1],'xiusinfo_')) 
					$searchdata['value'] = XiusHelperUsersearch::trimWhiteSpace($post[$keyNames[$i]]);
				else{
					while(!JString::stristr($keyNames[$i],'xiusinfo_')){
						$searchdata['value'][] = XiusHelperUsersearch::trimWhiteSpace($post[$keyNames[$i]]);
						$i++;
					}
					$i--;
				}
				$searchdata['operator'] = XIUS_EQUAL;
				
				$result = XiusLibUsersearch::checkSearchDataExistance($searchdata,$conditions);
				if(!$result)
					array_push($conditions,$searchdata);
				
				$start = false;
				$conditions = array_values($conditions);
				XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
				return;
			}
		}
	}
	
	/*$searchArray :- Required to check 
	 * $inArray :- check existance of searchArray in inArray
	 */
	function checkSearchDataExistance(array $searchArray,array $inArray)
	{
		if(empty($searchArray) || empty($inArray)
			|| count($searchArray) == 0 || count($inArray) == 0)
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
		
		XiusLibUsersearch::setDataInSession(XIUS_SORT,$sort,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_DIR,$dir,'XIUS');
	}
}

