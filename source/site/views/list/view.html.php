<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiussiteViewList extends XiusView
{
	
	function lists($owner = null,$tmpl='lists')
	{
		/*XITODO : get list according to owner*/
		$lModel =& XiusFactory::getModel('list','admin');

		$filter = array();

		if($owner == null)
			$user = JFactory::getUser();
		else
			$user = JFactory::getUser($owner);

		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter,'AND',true);
		
		// filter list according to privacy set by joomla
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$pagination =& $lModel->getPagination($filter,'AND');

		$this->assign('lists',$lists);
		$this->assign('pagination', $pagination);

		return parent::display($tmpl);
	}
	
	function saveas($msg = '',$tmpl='saveas')
	{
		$lModel =& XiusFactory::getModel('list','admin');

		$filter = array();

		$user = JFactory::getUser();

		if(!XiusHelpersUtils::isAdmin($user->id)){
			$filter['published'] = 1;
			$filter['owner'] = $user->id;
		}
		
		$lists = XiusLibrariesList::getLists($filter,'AND',false);

		$selectedListId = JRequest::getVar('listid', 0);

		$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		$this->assign('msg',$msg);
		
		parent::display($tmpl);
	}
	
	function edit($selectedListId,$isNew,$tmpl='edit')
	{
		$filter = array();

		$user = JFactory::getUser();

		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		//$lists = XiusLibrariesList::getLists($filter,'AND',false);
				
		//get editor for description of list
		$data['editor']		= & JFactory::getEditor();
		// get required data from session
		$data['conditions'] = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$data['sortId'] 	= XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,false);
		$data['dir'] 		= XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,'ASC');
		$data['join'] 		= XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');

		// get related data of conditions 
		$conditionHtml = XiusHelperList::formatConditions($data['conditions']);
		
		// if saveas is xiussaveexisting
		$data['listName'] 	= '';
		$data['listDesc'] 	= '';
		$tempParams=array();
		if($isNew === 'false'){
			$list = XiusLibrariesList::getList($selectedListId);
			$data['listName'] = $list->name;
			$data['listDesc'] = $list->description;
			$tempConfig = new JRegistry('xiuslist');
			$tempConfig->loadINI($list->params);
			$tempParams = $tempConfig->toArray('xiuslist');
		}
		
		// XITODO : if user is admin then ??
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		$data['sortableFields'] 	= XiusLibrariesUsersearch::getSortableFields($allInfo);
		$data['sortableFields'][] 	= array('key' => 'userid','value' => 'userid');
		
		
		// triger event for displaying xius privacy html
		$dispatcher =& JDispatcher::getInstance();
		$data['xiusListPrivacy'] = $dispatcher->trigger( 'xiusOnBeforeDisplayListDetails',array($tempParams));
				 
		$this->assign( 'conditionHtml',$conditionHtml);
		$this->assign( 'isNew' , $isNew );
		$this->assign( 'data' , $data );		
		//$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		
		parent::display($tmpl);
	}
	

}