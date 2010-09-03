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
			$list = $this->_getList($listId);			
			return $this->_displayResult(__FUNCTION__,$list);		
		}
		XiusLibrariesUsersearch::setDataInSession(XIUS_LISTID,0,'XIUS');
		
		$user =& JFactory::getUser();
		return $this->_lists($user->id);		
	}
	
	function _lists($owner)
	{
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );		
		return $view->lists($owner);
	}
	
	function _displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );		
		return $view->displayResult($fromTask,$list,'list');
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
				
		$this->_loadListInSession($list);
		return $this->_displayResult(__FUNCTION__,$list);
	}	

	function _loadListInSession($list)
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
	
	function _getList($listId=null)
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
	
	function displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );
		return $view->displayResult($fromTask,$list,'result');
	}
	
	function saveas()
	{				
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );

		$saveas 	= JRequest::getVar('isnew', 'true');
		$listId 	= JRequest::getVar('listid', 0);
		$listName 	= JRequest::getVar('xiusListName', '');
		
		$msg = '';
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );
		return $view->saveas($msg);
	}
	
	function edit()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$isNew 	= JRequest::getVar('isnew', 'true');
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );
		return $view->edit($listId,$isNew);		
	}
	
	function save()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$isNew  	= JRequest::getVar('isnew', 'true');
		$listName 	= JRequest::getVar('xiusListName', '');				
		global $mainframe;

		if(!$isNew && !$listId){
			$url = JRoute::_("index.php?option=com_xius&view=list",false);
			$msg = JText::_('Please select a list to save or save as a new');
			$mainframe->redirect($url,$msg);
		}
			
		$data = $this->_saveListChecks($isNew);
				
		if($data['success'] === true){
			$data = '';
			$data =  $this->_saveList($isNew);
		}				
			
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
         // XITODO : Send back to the previous URL
		$url = JRoute::_("index.php?option=com_xius&view=list",false);
		$msg = JText::_('YOU CAN NOT SAVE LIST');
		$returndata = array('id' => 0 , 'url' => $url , 'msg' => $msg , 'success' => false);
		return $returndata;		
	}
	
		
	
	function _saveList($new = true, $post=null,$params=null,$user=null)
	{		
		if($user === null)
			$user =& JFactory::getUser();
		
		if($post === null)
			$post = JRequest::get('POST');
		
		if(!$post)
			return;
		
		if($params === null)
			$params = array();				
		
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		// XITODO : do not user AllowRaw for all
		
		/*XITODO : set visible info and published also */		
		$listId 			= $post['listid'];
		$listName 			= $post['xiusListName'];
		
		// if saving new list then list id must id must be zero		
		$data['id'] 		= 0;
		$data['name'] 		= $listName;
		$data['description']= JRequest::getVar( 'xiusListDesc', $post['xiusListDesc'], 'post', 'string', JREQUEST_ALLOWRAW );
		$data['published'] 	= $post['xiusListPublish'];

		if(!$new){
			// load table for getting params
			$list			=& JTable::getInstance( 'list' , 'XiusTable' );
			$list->load($listId);
			$config 		= new JRegistry('xiuslist');
			$config->loadINI($list->params);
			$params 		= $config->toArray('xiuslist');
		
			$data['id'] 	= $listId;
			$data['name'] 	= $listName;;				
		}	
			
		$data['join'] 		= $post['xiusListJoinWith'];
		$data['sortinfo'] 	= $post['xiusListSortInfo'];
		$data['sortdir'] 	= $post['xiusListSortDir'];
		$data['owner'] 		= $user->id;
		$data['conditions'] = serialize($conditions);
				
		// trigger event before saving list
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