<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteControllerList extends XiusController
{
	function display()
	{
		$listId = JRequest::getVar('listid', 0);	
		if($listId){
			$list = $this->_loadList($listId);			
			return $this->_displayResult(__FUNCTION__,$list);		
		}
		XiusLibrariesUsersearch::setDataInSession(XIUS_LISTID,0,'XIUS');
		
		$user =& JFactory::getUser();
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'lists' );
		return $view->_showLists($user->id);			
	}
	
	function _displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'results' );
		return $view->displayResult($fromTask,$list);
	}
	
 	function _processList($list)
	{
		// XITODO : unset old data first
		// check session if list is already loaded 
		// then no need to load same list again and agian
		if($list->id === XiusLibrariesUsersearch::getDataFromSession(XIUS_LISTID,0,'XIUS'))
			return true;	
		
		//XiusLibrariesUsersearch::setDataInSession('listid',$listId,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_LISTID,$list->id,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_SORT,$list->sortinfo,'XIUS');	
		XiusLibrariesUsersearch::setDataInSession(XIUS_DIR,$list->sortdir,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$list->join,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,XiusHelperUsers::getUnserializedData($list->conditions),'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_VISIBLE,XiusHelperUsers::getUnserializedData($list->visibleinfo),'XIUS');
		return true;
	}
	
	function _loadList($listId=null)
	{
		if(null === $listId)
			$listId = JRequest::getVar('listid', 0);
					
		$user =& JFactory::getUser();
		if(!$listId)
			return $this->_showLists($user->id);			
			
		/*get list */
		$list = XiusLibrariesList::getList($listId);
		return $list;
	}
	
	function showlist()
	{
		global $mainframe;
		$listId = JRequest::getVar('listid', 0);	 
		
		$user =& JFactory::getUser();
		if($listId === 0)
			return $this->_showLists($user->id);			
			
		/*get list */
		$list = XiusLibrariesList::getList($listId);
		
		$url = JRoute::_('index.php?option=com_xius&view=list&task=display',false);
		if(empty($list))
			$mainframe->redirect($url,JText::_('INVALID LIST ID'),false);

		// when no task is there 
		$user =& JFactory::getUser();

		// XITODO : check access in function checkAccess		
		if($list)
			if(!XiusHelpersUtils::isAdmin($user->id) && !$list->published){					
				$msg = JText::_('DO NOT HAVE ACCESS RIGHTS');
				$mainframe->redirect($url,$msg,false);
				break;
			}
				
		$this->_processList($list);
		return $this->_displayResult(__FUNCTION__,$list);
	}
	
	function _showLists($owner)
	{
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'lists' );
		return $view->_showLists($owner);
	}
	
	function displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'results' );
		return $view->displayResult($fromTask,$list);
	}
	
	/*function join()
	{
		$list = $this->_loadList();
		$join = JRequest::getVar('xiusjoin','AND','POST');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		return $this->_displayResult('showlist',$list);
	}
	
	function delinfo()
	{
		$list = $this->_loadList();
		XiusLibrariesUsersearch::deleteSearchData();
		return $this->_displayResult('showlist',$list);
	}
	
	function addinfo()
	{
		$list = $this->_loadList();
		XiusLibrariesUsersearch::addSearchData();
		return $this->_displayResult('showlist',$list);
	}
	
	function sort()
	{		
		$list = $this->_loadList();
		XiusLibrariesUsersearch::processSortData();
		return $this->_displayResult('showlist',$list);
	}
	
	function sortdir()
	{		
		$list = $this->_loadList();
		XiusLibrariesUsersearch::processSortData();
		return $this->_displayResult('showlist',$list);		
	}
	
	function export()
	{	
		$viewName	= JRequest::getCmd('view', 'users');
		$viewType	= 'csv';
		$view		=& $this->getView( $viewName , $viewType );
		return $view->exportUser('showlist');	
	}
	
	function resetfilter()
	{
		$list = $this->_loadList();
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,'','XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'','XIUS');
		return $this->_displayResult('showlist',$list);
	}*/
	
	function saveOption()
	{				
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );

		$saveas 	= JRequest::getVar('saveas', 'savenew');
		$listId 	= JRequest::getVar('listid', 0);
		$listName 	= JRequest::getVar('xiusListName', '');
		
		$msg = '';
		$view->setLayout( 'results_saveoptions' );
		return $view->saveOption($msg);
	}
	
	function showListData()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$saveas 	= JRequest::getVar('saveas', 'newList');
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$view->setLayout( 'results_savelist' );
		return $view->saveList($listId,$saveas);		
	}
	
	function existingList()
	{
		$listId 	= JRequest::getVar('listid', 0);
//		if(!$listId){
//			$msg = JText::_('Please select a list to save or save as a new');
//			break;
//			}
//				
		$data = $this->_saveListChecks(false);
			
		if($data['success'] == true){
			$data = '';
			$data =  $this->_saveList(false);
		}
		
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );	
		$view->setLayout( 'results_success' );
		return $view->success($data);
	}
	
	function newList()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$listName 	= JRequest::getVar('xiusListName', '');				
		$data = $this->_saveListChecks(true);
				
		if($data['success'] == true){
			$data = '';
			$data =  $this->_saveList(true);
		}
				
		global $mainframe;				
		$mainframe->redirect($data['url'],$data['msg']);		
	}

	function _saveListChecks($new =true, $user = null)
	{
		if($user === null)
			$user =& JFactory::getUser();
		
		$returndata = array();
		
		// check for user type whoic can save list, and admin will always can create list
		$listCreator = unserialize(XiusHelpersUtils::getConfigurationParams('xiusListCreator','a:1:{i:0;s:19:"Super Administrator";}'));
		
		// allow user to create list who can create
		if(XiusHelperList::isAccessibleToUser($user,$listCreator)){
			$returndata = array('id' => 0 ,  'success' => true);
			return $returndata;			
		}
		
		$url = JRoute::_("index.php?option=com_xius&view=users",false);
		$msg = JText::_('YOU CAN NOT SAVE LIST');
		$returndata = array('id' => 0 , 'url' => $url , 'msg' => $msg , 'success' => false);
		return $returndata;		
	}
	
		
	
	function _saveList($new = true , $data = null, $post=null,$params=null,$user=null)
	{		
		if($user === null)
			$user =& JFactory::getUser();
		
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		// XITODO : do not user AllowRaw for all
		if($post == null)
			$post = JRequest::get('POST');
		
		if(!$post && !$data)
			return;
		/*XITODO : ask user for list details
		 * and whether to save this as a new list
		 * or update existing one
		 */
		if($params === null)
			$params = array();
			
		if($data === null){
			$listId 	= $post['listid'];
			$listName 	= $post['xiusListName'];
			/*XITODO : set visible info and published also */
			$data = array();
			// if saving new list then list id must id must be zero
			$data['id'] 		= 0;		
			$data['name'] 		= $listName;

			//$data['description']= $post['xiusListDesc'];
			$data['description']= JRequest::getVar( 'xiusListDesc', $post['xiusListDesc'], 'post', 'string', JREQUEST_ALLOWRAW );
			$data['published'] 	= $post['xiusListPublish'];

			if(!$new){
				// load table for getting params
				$list	=& JTable::getInstance( 'list' , 'XiusTable' );
				$list->load($listId);
				$config = new JRegistry('xiuslist');
				$config->loadINI($list->params);
				$params = $config->toArray('xiuslist');
			
				$data['id'] = $listId;
				$data['name'] = $post['xiusListName'];				
			}			
			
			$data['join'] = $post['xiusListJoinWith'];
			$data['sortinfo'] = $post['xiusListSortInfo'];
			$data['sortdir'] = $post['xiusListSortDir'];
			$data['owner'] = $user->id;
			$data['conditions'] = serialize($conditions);
		}		
		
		// trigger evet before saving list
		JPluginHelper::importPlugin( 'system' );
		$dispatcher =& JDispatcher::getInstance();
		
		$dispatcher->trigger( 'xiusOnBeforeSaveList', array( $post, &$params ) );
		$registry	= new JRegistry( 'xius' );		
		$registry->loadArray($params,'xius_list_params');
		
		// Get the complete INI string
		$data['params']	= $registry->toString('INI' , 'xius_list_params' );
		
		if(!($id = XiusLibrariesList::saveList($data)))
			$msg = JText::_('ERROR IN SAVE LIST');
		else
			$msg = JText::_('LIST SAVED SUCCESSFULLY');

		$url = JRoute::_("index.php?option=com_xius&view=list&task=showList&listid=".$id,false);
		
		$returndata = array();
		$returndata['id']	= $id;
		$returndata['url']	= $url;
		$returndata['msg'] 	= $msg; 		
		
		return $returndata;
	}	
}