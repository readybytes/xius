<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiussiteViewList extends XiusView
{
	protected $_name = 'list';
	
	function lists($owner = null,$tmpl='lists')
	{
		/*XITODO : get list according to owner*/
		$lModel = XiusFactory::getInstance('list', 'model');

		$filter = array();

		if($owner == null)
			$user = JFactory::getUser();
		else
			$user = JFactory::getUser($owner);

		if(!XiusHelperUtils::isAdmin($user->id)){
			$filter['published'] = 1;

			$privacy = XiusHelperUtils::getConfigurationParams('xiusListPrivacy',0);
			if($privacy) {
				$filter['owner'] = $user->id;
			}
		}

		$lists = $lModel->getLists($filter,'AND',true);
		
		// filter list according to privacy set by joomla
		XiusHelperList::filterListPrivacy($lists,$user);
		$pagination = $lModel->getPagination($filter,'AND');

		$this->assign('lists',$lists);
		$this->assign('pagination', $pagination);

		return parent::display($tmpl);
	}
	
	function saveas($msg = '',$tmpl='saveas')
	{
		$lModel = XiusFactory::getInstance ('list', 'model');

		$filter = array();

		$user = JFactory::getUser();

		if(!XiusHelperUtils::isAdmin($user->id)){
			$filter['published'] = 1;

			$privacy = XiusHelperUtils::getConfigurationParams('xiusListPrivacy',0);
			if($privacy) {	
				$filter['owner'] = $user->id;
			}
		}
		
		$lists = XiusLibList::getLists($filter,'AND',false);

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

		if(!XiusHelperUtils::isAdmin($user->id))
			$filter['published'] = 1;

		//$lists = XiusLibList::getLists($filter,'AND',false);
				
		//get editor for description of list
		$data['editor']		= JFactory::getEditor();
		// get required data from session
		$data['conditions'] = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$data['sortId'] 	= XiusLibUsersearch::getDataFromSession(XIUS_SORT,false);
		$data['dir'] 		= XiusLibUsersearch::getDataFromSession(XIUS_DIR,'ASC');
		$data['join'] 		= XiusLibUsersearch::getDataFromSession(XIUS_JOIN,'AND');

		// get related data of conditions 
		$conditionHtml = XiusHelperList::formatConditions($data['conditions']);
		
		// if saveas is xiussaveexisting
		$data['listName'] 	= '';
		$data['listDesc'] 	= '';
		$tempParams=array();
		if($isNew === 'false'){
			$list = XiusLibList::getList($selectedListId);
			$data['listName'] = $list->name;
			$data['listDesc'] = $list->description;
			$tempConfig = new JRegistry('xiuslist');
			$tempConfig->loadString($list->params,'INI');
			$tempParams = $tempConfig->toArray('xiuslist');
		}
		
		// XITODO : if user is admin then ??
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibInfo::getInfo($filter,'AND',false);
		$data['sortableFields'] 	= XiusLibUsersearch::getSortableFields($allInfo);
		//As we will not be able to sort as per userid.
		//$data['sortableFields'][] 	= array('key' => 'userid','value' => 'userid');
		
		
		// triger event for displaying xius privacy html
		JPluginHelper::importPlugin('xius');
		$dispatcher = JDispatcher::getInstance();
		$data['xiusListPrivacy'] = $dispatcher->trigger( 'xiusOnBeforeDisplayListDetails',array($tempParams));
				 
		$this->assign( 'conditionHtml',$conditionHtml);
		$this->assign( 'isNew' , $isNew );
		$this->assign( 'data' , $data );		
		//$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		
		parent::display($tmpl);
	}
	

}
