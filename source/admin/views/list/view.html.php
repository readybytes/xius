<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewList extends XiusView 
{
	protected $_name = "list";
	
    function display($tpl = null)
    {
		$lModel = XiusFactory::getInstance ('list', 'model');	
		$lists 	= $lModel->getLists();
		$pagination = $lModel->getPagination();
		
		$this->assign('lists', $lists);
		$this->assignRef( 'pagination'	, $pagination );
		return parent::display($tpl);
    }
	
    /*
     * view for list when editing the list
     */
	function editList($id,$tpl=null)
	{	
		$list 			= XiusLibList::getList($id);
		
		// load xml file
		$listxml 		= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'xiuslist';		
		$paramsxmlpath 	= $listxml.'.xml';
		$ini			= $listxml.'.ini';
		$data			= JFile::read($ini);		
		
		// XITODO : raise error if xml file is not found
		$config  = new XiusParameter('','');
		if(JFile::exists($paramsxmlpath))
			$config  = new XiusParameter($data,$paramsxmlpath);
				
		$config->bind($list->params);

		//get editor for description of list
		$editor 		= JFactory::getEditor();
		
		// get sortable fields
		$filter = array();
		//$filter['published'] = true;
		$allInfo = XiusLibInfo::getInfo($filter,'AND',false);
		$sortableFields 	= XiusLibUsersearch::getSortableFields($allInfo);
		//$sortableFields[] 	= array('key' => 'userid','value' => 'userid');
		
		// get the user info, who is owner of the list
		$user =  JFactory::getUser($list->owner);
		
		$joomlaGroups =  XiusHelperUsers::getJoomlaGroups();
				
		foreach ($joomlaGroups as $group)
		{
			if(isset($user->groups[$group->id]))
				$user->groups[$group->id] = $group->title;
		}
		
		// format the conditions applied		
		$conditions = unserialize($list->conditions);	
		//XITODO :: Autoloading form back ens to fron end	
		require_once  JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		$conditionHtml = XiusHelperList::formatConditions($conditions);
			
		// load a temporary params from table, which can be used by other plugins
		$tempConfig = new JRegistry('xiuslist');
		$tempConfig->loadString($list->params,"INI");
		$tempParams = $tempConfig->toArray('xiuslist');

		// triger event for displaying xius privacy html
		$dispatcher 			= JDispatcher::getInstance();
		$xiusListPrivacy	 	= $dispatcher->trigger( 'xiusOnBeforeDisplayListDetails',array($tempParams));
				
		$this->assign( 'xiusListPrivacy' , $xiusListPrivacy);
		$this->assign( 'conditionHtml' , $conditionHtml ); 
		$this->assign( 'list' , $list );
		$this->assign( 'config' , $config );
		$this->assign( 'editor' , $editor );
		$this->assign( 'sortableFields' , $sortableFields );
		$this->assign( 'user' , $user );
		$this->assign( 'allInfo' , $allInfo );		
		
		// Set the titlebar text
		JToolBarHelper::title( XiusText::_( 'XIUS_EDIT_LIST' ), 'list' );		
		return parent::display($tpl);
	}
	
	
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{
		$task = JFactory::getApplication()->input->get('task');
		
		if($task == 'editList')
		{
			JToolBarHelper::apply('apply', XiusText::_('APPLY'));
			JToolBarHelper::save('save',XiusText::_('SAVE'));
			JToolBarHelper::cancel( 'cancel', XiusText::_('CLOSE' ));
			
			return true;
		}
		
		JToolBarHelper::publishList('publish', XiusText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', XiusText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', XiusText::_( 'DELETE' ));
	}

}
