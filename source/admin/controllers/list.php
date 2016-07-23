<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 	support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusControllerList extends JControllerLegacy
{
    /**
     * Constructor
     * @access private
     * @subpackage profilestatus
     */
	function __construct($config = array())
	{
		parent::__construct($config);

		//registering some extra in all task list which we want to call
		$this->registerTask( 'orderup' , 'saveOrder' );
		$this->registerTask( 'orderdown' , 'saveOrder' );
	}

	function remove()
	{
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );

		$data = $this->_remove();

		$cache = JFactory::getCache('com_content');
		$cache->clean();
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$this->setRedirect($link, $data['message']);
		return false;		
	}

	function editList()
	{
		$id = JRequest::getVar('editId', 0 );

		$viewName	= JRequest::getCmd( 'view' , 'list' );

		// Get the document object
		$document	= JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();

		$view		= $this->getView( $viewName , $viewType );

		if($id){
			$layout		= JRequest::getCmd( 'layout' , 'list.edit' );
			$view->setLayout( $layout );
			echo $view->editList($id);
			return;
		}

		// XITODO : when id is not set then what to do
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$this->setRedirect($link);
		return false;
	}

	function save()
	{
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS_METHOD_NOT_ALLOWED') );
			return false;
		}

		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$this->setRedirect($link, $data['msg']);
		return false;
	}

	function apply()
	{
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS_METHOD_NOT_ALLOWED') );
			return;
		}

		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=list&task=editList&editId='.$data['id'], false);
		$this->setRedirect($link, $data['msg']);
		return false;
	}

	function _processSave($post=null)
	{
		if($post == null)
			$post	= JRequest::get('post');

		JPluginHelper::importPlugin( 'xius' );
		jimport('joomla.filesystem.file');

		$data = array();

		// load existing data of table of this list
		$list	= XiusFactory::getInstance( 'list' , 'Table' );
		$list->load($post['id']);
		$config = new JRegistry('xiuslist');
		$config->loadString($list->params,"INI");
		$params = $config->toArray('xiuslist');

		// trigger evet before saving list
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnBeforeSaveList', array( $post, &$params ) );

		// serialize the joomla user privacy params
		$registry	= new JRegistry;
		if(is_array($post['params'])
				&& array_key_exists('xiusListViewGroup',$post['params'])){
			$temp 		= $post['params']['xiusListViewGroup'];
			$params['xiusListViewGroup'] = serialize($temp);
		}
		$registry->loadArray($params,'xius_list_params');

		// Get the complete INI string
		$data['params']	= $registry->toString('INI' , 'xius_list_params' );

		// get the required data
		$data['id'] 			= $post['id'];
		$data['name'] 			= $post['xiusListName'];
		$data['visibleinfo'] 	= $post['xiusListVisibleInfo'];
		$data['sortinfo'] 		= $post['xiusListSortInfo'];
		$data['sortdir'] 		= $post['xiusListSortDir'];
		$data['join']	 		= $post['xiusListJoinWith'];
		$data['description']	= JRequest::getVar( 'xiusListDescription', $post['xiusListDescription'], 'post', 'string', JREQUEST_ALLOWRAW );
		$data['published'] 		= $post['published'];

		unset($post['id']);
		unset($post['labelName']);
		unset($post['published']);
		unset($post['params']);

		$iModel	= XiusFactory::getInstance ( 'list', 'model' );
		$storedInfo['id'] = $iModel->store($data);

		if(!$storedInfo['id'])
			$storedInfo['msg'] = XiusText::_('ERROR_IN_SAVING_INFO');
		else
			$storedInfo['msg'] = XiusText::_('INFO_SAVED');

		$data['id'] = $storedInfo['id'];

		$list = array();
		$list['id'] = $storedInfo['id'];
		$list['data'] = $data;

		return $storedInfo;
	}

	function _remove($ids=null)
	{
		if($ids == null)
			$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$count	= count($ids);

		$row	= XiusFactory::getInstance ( 'list', 'table');

		$data = array();
		$data['message'] = '';
		$data['success'] = false;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$data['message']	= XiusText::_('ERROR_IN_REMOVING_LIST').' '. $id;
					return $data;
				}
			}

			$data['message'] = $count.' '.XiusText::_('LIST_REMOVED');	;
			$data['success'] = true;
		}

		return $data;
	}


	function publish()
	{
		$mainframe = JFactory::getApplication();
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, XiusText::_( 'NO_ITEMS_SELECTED' ) );
		}

		$result = $this->_updatePublish(1,$ids);

		if($result['success'])
			$msg = $count.' '.XiusText::_('ITEM_UNPUBLISHED' );
		else
			$msg = XiusText::_('UNABLE_TO_UNPUBLISH_LIST');

		$msg = $count. ' '. XiusText::_('ITEM_PUBLISHED' );
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$this->setRedirect($link, $msg);
		return false;
	}

	function unpublish()
	{
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, XiusText::_( 'NO_ITEMS_SELECTED' ) );
		}

		$result = $this->_updatePublish(0,$ids);

		if($result['success'])
			$msg = $count.' '.XiusText::_('ITEM_UNPUBLISHED' );
		else
			$msg = XiusText::_('UNABLE_TO_UNPUBLIS_LIST');

		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$this->setRedirect($link, $msg);
		return false;
	}


	function _updatePublish($value , $ids = null)
	{
		if($ids == null)
			$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );


		$data = array();
		$data['success'] = false;
		$data['msg'] = '';

		$lModel =XiusFactory::getInstance ('list', 'model');
		foreach($ids as $id)
			if(!$lModel->updatePublish($id,$value)){
				$data['msg'] = XiusText::_('UNABLE_TO_PUBLISH_UNPUBLISH_LIST');
				return $data;
			}

		$data['success'] = true;
		$data['msg'] = XiusText::_('PUBLISH_UNPUBLISH_LIST');

		return $data;
	}


	function saveOrder()
	{
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

 		$result = $this->_saveOrder($id,$direction);

		$this->setRedirect( XiusRoute::_('index.php?option=com_xius&view=list',false),$result['msg']);
		return false;
	}


	function _saveOrder($id , $direction)
	{
		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];

			// Load the JTable Object.
			$table	= XiusFactory::getInstance( 'list' , 'Table' );

			$table->load( $id );

			if(!$table->move( $direction ))
				$data = array('msg' => $table->getError() , 'success' => false );
			else
				$data = array('msg' => XiusText::_('ORDERED_LIST') , 'success' => true );
		}
		else
			$data = array('msg' => XiusText::_('NOT_ORDERED') , 'success' => false );

		return $data;
	}
}
