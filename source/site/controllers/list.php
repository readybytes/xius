<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteControllerList extends XiusController
{
	function __construct($config=array())
	{
		parent::__construct($config);
	}
	
	function display($cachable = false, $urlparams = array()) 
	{
		return $this->lists();	
	}
	
	function lists()
	{
		$listId = JRequest::getVar('listid', 0);	
		if($listId){
			$list = $this->_getList($listId);			
			return $this->_displayResult(__FUNCTION__,$list);		
		}
		XiusLibUsersearch::setDataInSession(XIUS_LISTID,0,'XIUS');
		
		$user = JFactory::getUser();
		
		$view = $this->getView();

		// set and reset the vars in current url
		$view->setXiUrl(array('view'=>$this->getName(),'task'=>'showList',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));
		return $view->lists($user->id);				
	}
	
	function _displayResult($fromTask,$list='')
	{
		$view = $this->getView();
		// set and reset the vars in current url
		$view->setXiUrl(array('view'=>'users','task'=>'search',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));
		return $view->displayResult($fromTask,$list,'list');
	} 	
	
	function showlist()
	{
		$mainframe = JFactory::getApplication();
		$listId = JRequest::getVar('listid', 0);	 
		
		$user = JFactory::getUser();
		if($listId == 0)
			return $this->lists($user->id);			
			
		/*get list */
		$list = XiusLibList::getList($listId);
	    $url = XiusRoute::_('index.php?option=com_user&view=login',false);
		if(empty($list))
		{
			if(XiusModel::isIdExist('list',$listId))
				$mainframe->redirect($url,XiusText::_('PERMISSION_DENIED'),false);
			else
			$mainframe->redirect($url,XiusText::_('INVALID_LIST_ID'),false);
	    }
       
		// when no task is there 
		$user = JFactory::getUser();

		// XITODO : check access in function checkAccess		
		if($list)
			if(!XiusHelperUtils::isAdmin($user->id) && !$list->published){					
				$msg = XiusText::_('DO_NOT_HAVE_ACCESS_RIGHTS');
				$mainframe->redirect($url,$msg,false);
				break;
			}
		//set the default limit in list result		
		$limit = XiusHelperUtils::getConfigurationParams('xiusLimit','20');
        JFactory::getApplication()->setUserState('global.list.limit',$limit);
		$this->_loadListInSession($list);
		return $this->_displayResult(__FUNCTION__,$list);
	}	

	function _loadListInSession($list)
	{
		// check session if list is already loaded 
		// then no need to load same list again and agian
		 if($list->id === XiusLibUsersearch::getDataFromSession(XIUS_LISTID,0,'XIUS'))
		 {
			if($list->conditions === serialize(XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,0,'XIUS' )))
			   return true;	
		 }
		
		//XiusLibUsersearch::setDataInSession('listid',$listId,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_LISTID,$list->id,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_SORT,$list->sortinfo,'XIUS');	
		XiusLibUsersearch::setDataInSession(XIUS_DIR,$list->sortdir,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,$list->join,'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,XiusHelperUsers::getUnserializedData($list->conditions),'XIUS');
		XiusLibUsersearch::setDataInSession(XIUS_VISIBLE,XiusHelperUsers::getUnserializedData($list->visibleinfo),'XIUS');
		return true;
	}
	
	function _getList($listId=null)
	{
		if(null === $listId)
			$listId = JRequest::getVar('listid', 0);
					
		$user = JFactory::getUser();
		if(!$listId)
			return $this->_showLists($user->id);			
			
		/*get list */
		$list = XiusLibList::getList($listId);
		return $list;
	}

	function saveas()
	{				
		$view		= $this->getView();
		// set and reset the vars in current url
		$view->setXiUrl(array('view'=>$this->getName(),'task'=>'edit',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));

		$saveas 	= JRequest::getVar('isnew', 'true');
		$listId 	= JRequest::getVar('listid', 0);
		$listName 	= JRequest::getVar('xiusListName', '');
		
		$msg = '';		
		return $view->saveas($msg);
	}
	
	function edit()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$isNew 	= JRequest::getVar('isnew', 'true');
		
		$view		= $this->getView();
		// set and reset the vars in current url
		$view->setXiUrl(array('view'=>$this->getName(),'task'=>'save',
							'tmpl'=>null,'listid'=>$listId,'isnew'=>null));
		return $view->edit($listId,$isNew);		
	}
	
	function save()
	{
		$listId 	= JRequest::getVar('listid', 0);
		$isNew  	= JRequest::getVar('isnew', 'true');
		$listName 	= JRequest::getVar('xiusListName', '');				
		$mainframe = JFactory::getApplication();

		if(!$isNew && !$listId){			
			$this->getView()->setXiUrl(array('view'=>$this->getName(),'task'=>'lists',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));
		
			$url = XiusRoute::_($this->getView()->getXiUrl(),false);
			$msg = XiusText::_('PLEASE_SELECT_A_LIST_TO_SAVE_OR_SAVE_AS_A_NEW');
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
			$user = JFactory::getUser();
		
		$returndata = array();
		
		// check for user type whoic can save list, and admin will always can create list
		$listCreator = unserialize(XiusHelperUtils::getConfigurationParams('xiusListCreator','a:1:{i:0;s:19:"Super Administrator";}'));
		
		// allow user to create list who can create
		if(XiusHelperList::isAccessibleToUser($user,$listCreator)){
			$returndata = array('id' => 0 ,  'success' => true);
			return $returndata;			
		}
         // XITODO : Send back to the previous URL
        $this->getView()->setXiUrl(array('view'=>$this->getName(),'task'=>'lists',
								'tmpl'=>null,'listid'=>null,'isnew'=>null));
		
        $url = XiusRoute::_($this->getView()->getXiUrl(),false);		
		$msg = XiusText::_('YOU_CAN_NOT_SAVE_LIST');
		$returndata = array('id' => 0 , 'url' => $url , 'msg' => $msg , 'success' => false);
		return $returndata;		
	}
	
		
	
	function _saveList($new = true, $post=null,$params=null,$user=null)
	{		
		if($user === null)
			$user = JFactory::getUser();
		
		if($post === null)
			$post = JRequest::get('POST');
		
		if(!$post)
			return;
		
		if($params === null)
			$params = array();				
		
		$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		// XITODO : do not user AllowRaw for all
		
		/*XITODO : set visible info and published also */		
		$listId 			= $post['listid'];
		$listName 			= $post['xiusListName'];
		
		// if saving new list then list id must id must be zero		
		$data['id'] 		= 0;
		$data['name'] 		= $listName;
		$data['description']= JRequest::getVar( 'xiusListDesc', $post['xiusListDesc'], 'post', 'string', JREQUEST_ALLOWRAW );
		$data['published'] 	= $post['xiusListPublish'];

		// XITODO : convert string 'false' into bollean false
		if($new==='false'){
			// load table for getting params
			$list			= XiusFactory::getInstance( 'list' , 'Table' );
			$list->load($listId);
			$config 		= new JRegistry('xiuslist');
			$config->loadString($list->params,'INI');
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
		JPluginHelper::importPlugin( 'xius' );
		$dispatcher = JDispatcher::getInstance();
		
		$dispatcher->trigger( 'xiusOnBeforeSaveList', array( $post, &$params ) );
		$registry	= new JRegistry( 'xius' );		
		$registry->loadArray($params,'xius_list_params');
		
		// Get the complete INI string
		$data['params']	= $registry->toString('INI' , 'xius_list_params' );
		
		if(!($id = XiusLibList::saveList($data)))
			$msg = XiusText::_('ERROR_IN_SAVE_LIST');
		else
			$msg = XiusText::_('LIST_SAVED_SUCCESSFULLY');

		$this->getView()->setXiUrl(array('view'=>$this->getName(),'task'=>'showList',
							'tmpl'=>null,'listid'=>$id,'isnew'=>null));
			
		$url = XiusRoute::_($this->getView()->getXiUrl(),false);
		
		$returndata = array();
		$returndata['id']	= $id;
		$returndata['url']	= $url;
		$returndata['msg'] 	= $msg; 		
		return $returndata;
	}
	/**
	* Delete list by owner. (Currently this option is disabled)
	*/
	function delete() 
	{
		$listId =  JRequest::getvar("listid", 0);
		$loginUser = JFactory::getUser()->id;
		
		$filter = Array('published' => 1, 'id'=>$listId, 'owner' =>$loginUser);
		$lModel = XiusFactory::getInstance('list', 'model'); 
		$list	= $lModel->getLists($filter,'AND',true);
		
		if(empty($list))
			$data['message'] = "You do not have permission to delete this list";	
		else 
		{
			require_once JPATH_ROOT.DS.'administrator/components/com_xius/controllers/list.php';
			$data = XiusFactory::getInstance('list','controller')->_remove(Array($listId));
		}
		
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		JFactory::getApplication()->redirect($link, $data['message']);
	}
}
