<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusControllerUsers extends JController
{
	
	function display()
	{
		$this->displaySearch();
	}
	
	function displaySearch()
	{
		/*XITODO : Collect all info here
		 * ask admin , how many no's of info
		 * he want's to display at a time , and add more links.
		 * never assume anything
		 * show only searchable information
		 * for admin non-published info should be visible
		 */
		
		$subtask = JRequest::getVar('subtask', ''); 
		$supltytask = JRequest::getVar('suplytask', '');
		switch($subtask){
			
			case 'xiussearch':
				$scanned = JRequest::getVar('scanned', 0,'POST'); 
				if($scanned)
					break;
					
				$conditions = XiusLibrariesUsersearch::processSearchData();
				XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
				
				$join = JRequest::getVar('xius_join','AND','POST');
				XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
				break;
			case 'xiusjoin':
				$join = JRequest::getVar('xiusjoin','AND','POST');
				XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
				break;
			case 'xiusdelinfo':
				XiusLibrariesUsersearch::deleteSearchData();
				break;
			case 'xiusaddinfo':
				XiusLibrariesUsersearch::addSearchData();
				break;
			case 'xiussort':
			case 'xiussortdir':
				XiusLibrariesUsersearch::processSortData();
				break;
			case 'xiusexport':
				return $this->_exportUser(__FUNCTION__);
				break;
			default	:
				if(!$supltytask)
					return $this->_showSearchPanel();
				break;
		}
			
		return $this->_displayResult(__FUNCTION__);
	}
	
	
	function _showSearchPanel()
	{
		$filter = array();
		$filter['published'] = true;
		
		$count = XiusHelpersUtils::getDisplayInformationCount();
		
		if($count === XIUS_ALL || $count === 0)
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		else
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',true,0,$count);
		
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$view->setLayout( 'default' );

		/*XITODO : pass only searchable information 
		 * Trigger event before displaying search 
		 */
		return $view->displaySearch($allInfo);
	}
	
	
	function _displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'results' );
		return $view->displayResult($fromTask,$list);
	}
	

	function _exportUser($fromTask)
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$viewType	= 'csv';
		$view		=& $this->getView( $viewName , $viewType );
		return $view->exportUser($fromTask);
	}
	
	
	
	function displayList()
	{
		global $mainframe;
		$listId = JRequest::getVar('listid', 0);
		$subtask = JRequest::getVar('subtask', ''); 
		
		$user =& JFactory::getUser();
		if(!$listId && $subtask != 'xiussavelist' 
			&&	$subtask != 'xiusexport')
			return $this->_showLists( $user->id);
			
	
		/*get list */
		$lModel =& XiusFactory::getModel('list','admin');
		$list = $lModel->getList($listId);
		
		$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList',false);
		if(empty($list))
			$mainframe->redirect($url,JText::_('INVALID LIST ID'),false);
		
		switch($subtask){
			case 'xiusjoin':
				$join = JRequest::getVar('xiusjoin','AND','POST');
				XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
				break;
			case 'xiusdelinfo':
				XiusLibrariesUsersearch::deleteSearchData();
				break;
			case 'xiusaddinfo':
				XiusLibrariesUsersearch::addSearchData();
				break;
			case 'xiussort' :
			case 'xiussortdir':
				XiusLibrariesUsersearch::processSortData();
				break;
			case 'xiusexport':
				return $this->_exportUser(__FUNCTION__);
				break;
			default	:
				$user =& JFactory::getUser();
				if($list)
					if(!XiusHelpersUtils::isAdmin($user->id) && !$list->published){
						$url = JRoute::_("index.php?option=com_xius&view=users&task=displayList",false);
						$msg = JText::_('DO NOT HAVE ACCESS RIGHTS');
						$mainframe->redirect($url,$msg,false);
						break;
					}
				$this->_processList($list);
				break;
		}
		
		return $this->_displayResult(__FUNCTION__,$list);
		
	}
	
	
	function _processList($list)
	{
		//XITODO : unset old data first
		//XiusLibrariesUsersearch::setDataInSession('listid',$listId,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_SORT,$list->sortinfo,'XIUS');	
		XiusLibrariesUsersearch::setDataInSession(XIUS_DIR,$list->sortdir,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$list->join,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,unserialize($list->conditions),'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_VISIBLE,unserialize($list->visibleinfo),'XIUS');
		return true;
	}
	
	
	function _showLists($owner)
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'lists' );
		return $view->_showLists($owner);
	}
		
	
	
	function displaySaveOption()
	{
		$user =& JFactory::getUser();
				
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$subtask = JRequest::getVar('subtask', '');
		
		$listId = JRequest::getVar('listid', 0);
		$listName = JRequest::getVar('xius_list_name', '');
		
		$msg = '';
		
		switch($subtask){
			case 'xiussaveexisting':
				if(!$listId){
					$msg = JText::_('Please select a list to save or save as a new');
					break;
				}
				
				$data = $this->_saveListChecks(false);
				
				if($data['success'] == true){
					$data = '';
					$data =  $this->_saveList(false);
				}
					
				$view->setLayout( 'results_success' );
				return $view->success($data);
				break;
			case 'xiussavenew' :
				
				if(!$listName){
					$msg = JText::_('Please provide list name');
					break;
				}
				
				$data = $this->_saveListChecks(false);
				
				if($data['success'] == true){
					$data = '';
					$data =  $this->_saveList(false);
				}
				
				$data =  $this->_saveList(true);
				$view->setLayout( 'results_success' );
				return $view->success($data);
				break;
			default :
				break;
		}
					
		$view->setLayout( 'results_saveoptions' );
		return $view->displaySaveOption($msg);
	}
	

	function _saveListChecks($new = true)
	{
		$user =& JFactory::getUser();
		
		$returndata = array();
		
		/* Check for admin only admin can save list	 */
		if(!XiusHelpersUtils::isAdmin($user->id)){
			$url = JRoute::_("index.php?option=com_xius&view=users",false);
			$msg = JText::_('YOU CAN NOT SAVE LIST');
			$returndata = array('id' => 0 , 'url' => $url , 'msg' => $msg , 'success' => false);
			return $returndata;
		}
		
		$returndata = array('id' => 0 ,  'success' => true);
		return $returndata;
		
	}
	
		
	
	function _saveList($new = true , $data = null)
	{
		$user =& JFactory::getUser();
		
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);

		/*XITODO : ask user for list details
		 * and whether to save this as a new list
		 * or update existing one
		 */
		
		if($data == null){
			$listId = JRequest::getVar('listid', 0);
			$listName = JRequest::getVar('xius_list_name', 'LIST'.$listId);
			/*XITODO : set visible info and published also */
			$data = array();
			
			$data['id'] = $listId;
			
			if($new){
				$data['id'] = 0;
				$data['name'] = $listName;
				$data['description'] = JRequest::getVar('xius_list_desc', '');
				$data['published'] = JRequest::getVar('xius_list_publish', 1);
			}
			
			$data['join'] = XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');
			$data['sortinfo'] = XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,'userid');
			$data['sortdir'] = XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,'ASC');
			$data['owner'] = $user->id;
			$data['conditions'] = serialize($conditions);
		}
		
		if(!($id = XiusLibrariesList::saveList($data)))
			$msg = JText::_('ERROR IN SAVE LIST');
		else
			$msg = JText::_('LIST SAVED SUCCESSFULLY');

		$url = JRoute::_("index.php?option=com_xius&view=users&task=displayList&listid=".$id,false);
		
		$returndata = array();
		$returndata['id']	= $id;
		$returndata['url']	= $url;
		$returndata['msg'] 	= $msg; 		
		
		return $returndata;
	}
	
	function displayAdvanceSearch()
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );		
		$view->setLayout( 'advance_search' );
		return $view->displayAdvanceSearch();	
	}

	function runCron()
	{
		if(XiusHelpersUtils::verifyCronRunRequired() == false)
			return;
			
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_START_TIME,$time);
		
		XiusLibrariesUsersearch::updateCache();
		
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_END_TIME,$time);
		
		return;
			
		/*$startTime = XiusHelpersUtils::getOtherConfigParams('cache',XIUS_CACHE_START_TIME,0);
		$endTime = XiusHelpersUtils::getOtherConfigParams('cache',XIUS_CACHE_END_TIME,0);
		
		$currentTime = XiusLibrariesUsersearch::getTimestamp();
		
		$timeGap = $currentTime - $endTime;
		$totalRunTime = $endTime - $startTime;
		
		if($timeGap < XIUS_CRON_TIME_MULTIPLIER * $totalRunTime)
			return ;
			
		$limitStart=JRequest::getVar('limitStart', 0, 'GET');
			
		if($limitStart == 0){
			$time = XiusLibrariesUsersearch::getTimestamp();
			XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_START_TIME,$time);
		}
		
		$limit = array();
		$limit['limitStart'] = $limitStart;
		$limit['limit'] = XiusHelpersUtils::getUserLimit();
		
		$insertedRows =$this->_runCron($limit); 
		
		if($insertedRows == $limit['limit']){
			$limitStart += $limit['limit'];
    		$mainframe->redirect(JRoute::_("index.php?option=com_xius&view=users&task=runCron&xiuskey=".$secureKey."&limitStart=".$limitStart,false));
		}
		
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_END_TIME,$time);
		
		return;*/
	}
	
	function _runCron($limit)
	{
		$cache = XiusFactory::getCacheObject();
		if($limit['limitStart'] == 0) {
			if(!$cache->createTable(true))
				return false;
		}
		$getDataQuery = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		return $cache->insertIntoTable($getDataQuery,true,$limit);		
	}
	
}
