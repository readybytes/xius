<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewList extends JView 
{
    function display($tpl = null)
    {
		$lModel =& XiusFactory::getModel('list');
		
		$lists = $lModel->getLists();
		$pagination = $lModel->getPagination();
		
		$this->setToolbar();			
		$this->assign('lists', $lists);
		$this->assignRef( 'pagination'	, $pagination );
		return parent::display($tpl);
    }
	
    /*
     * view for list when editing the list
     */
	function editList($id,$tpl=null)
	{		
		$lModel 		= & XiusFactory::getModel('list');
		$list 			= $lModel->getList($id);
		
		//$row			= & JTable::getInstance( 'profiletypes' , 'XiPTTable' );
		//$row->load( $id );	
		
		$listxml 		= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'xiuslist';		
		$paramsxmlpath 	= $listxml.'.xml';
		$ini			= $listxml.'.ini';
		$data			= JFile::read($ini);		
		
		if(JFile::exists($paramsxmlpath))
			$config  = new JParameter($data,$paramsxmlpath);
		else 
			$config  = new JParameter('','');
				
		$config->bind($list->params);

		//get editor for description of list
		$editor 		=& JFactory::getEditor();
		
		// get sortable fields
		$filter = array();
		//$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		$sortableFields 	= XiusLibrariesUsersearch::getSortableFields($allInfo);
		$sortableFields[] 	= array('key' => 'userid','value' => 'userid');
		
		// get the user info, who is owner of the list
		$user = & JFactory::getUser($list->owner);
		$infoName = array();
		$conditions = unserialize($list->conditions);
		foreach($conditions as $c){
			$info = XiusLibrariesInfo::getInfo(array('id'=>$c['infoid']));
			if($info || $info!=array())	
				$infoName[$c['infoid']] = $info[0]->labelName;
		}
			
		$tempConfig = new JRegistry('xiuslist');
		$tempConfig->loadINI($list->params);
		$tempParams = $tempConfig->toArray('xiuslist');
		// triger event for displaying xius privacy html
		$dispatcher =& JDispatcher::getInstance();
		$xiusListPrivacy = $dispatcher->trigger( 'xiusOnBeforeDisplayListDetails',array($tempParams));
		
		$this->assign( 'xiusListPrivacy' , $xiusListPrivacy);
		$this->assign( 'conditions' , $conditions ); 
		$this->assign( 'list' , $list );
		$this->assign( 'config' , $config );
		$this->assign( 'editor' , $editor );
		$this->assign( 'sortableFields' , $sortableFields );
		$this->assign( 'user' , $user );
		$this->assign( 'allInfo' , $allInfo );
		$this->assign( 'infoName' , $infoName );
		
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'XIUS EDIT LIST' ), 'list' );		
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

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'LIST' ), 'list' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xius');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
	}

}
?>