<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusControllerList extends JController
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

//    function display()
//    {
//		parent::display();
//    }
//

	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );

		$data = $this->_remove();

		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $data['message']);
	}

	function editList()
	{
		$id = JRequest::getVar('editId', 0 );

		$viewName	= JRequest::getCmd( 'view' , 'list' );

		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();

		$view		=& $this->getView( $viewName , $viewType );

		if($id){
			$layout		= JRequest::getCmd( 'layout' , 'list.edit' );
			$view->setLayout( $layout );
			echo $view->editList($id);
			return;
		}

		// XITODO : when id is not set then what to do
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link);
	}

	function save()
	{
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS METHOD NOT ALLOWED') );
			return false;
		}

		global $mainframe;
		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $data['msg']);
	}

	function apply()
	{
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS METHOD NOT ALLOWED') );
			return;
		}

		global $mainframe;

		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=list&task=editList&editId='.$data['id'], false);
		$mainframe->redirect($link, $data['msg']);
	}

	function _processSave($post=null)
	{
		if($post == null)
			$post	= JRequest::get('post');

		JPluginHelper::importPlugin( 'xius' );
		jimport('joomla.filesystem.file');

		$data = array();

		// load existing data of table of this list
		$list	=& JTable::getInstance( 'list' , 'XiusTable' );
		$list->load($post['id']);
		$config = new JRegistry('xiuslist');
		$config->loadINI($list->params);
		$params = $config->toArray('xiuslist');

		// trigger evet before saving list
		JPluginHelper::importPlugin('xius');
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnBeforeSaveList', array( $post, &$params ) );

		// serialize the joomla user privacy params
		$registry	=& JRegistry::getInstance( 'xius' );
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
			$storedInfo['msg'] = XiusText::_('ERROR IN SAVING INFO');
		else
			$storedInfo['msg'] = XiusText::_('INFO SAVED');

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
					$data['message']	= XiusText::_('ERROR IN REMOVING LIST').' '. $id;
					return $data;
				}
			}

			$data['message'] = $count.' '.XiusText::_('LIST REMOVED');	;
			$data['success'] = true;
		}

		return $data;
	}


	function publish()
	{
		global $mainframe;
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, XiusText::_( 'NO ITEMS SELECTED' ) );
		}

		$result = $this->_updatePublish(1,$ids);

		if($result['success'])
			$msg = $count.' '.XiusText::_('ITEM UNPUBLISHED' );
		else
			$msg = XiusText::_('Unable to unblish list');

		$msg = $count. ' '. XiusText::_('ITEM PUBLISHED' );
		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $msg);
		return true;
	}

	function unpublish()
	{
		global $mainframe;
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, XiusText::_( 'NO ITEMS SELECTED' ) );
		}

		$result = $this->_updatePublish(0,$ids);

		if($result['success'])
			$msg = $count.' '.XiusText::_('ITEM UNPUBLISHED' );
		else
			$msg = XiusText::_('Unable to unblish list');

		$link = XiusRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $msg);
		return true;
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
				$data['msg'] = XiusText::_('Unable to publish/unpublish list');
				return $data;
			}

		$data['success'] = true;
		$data['msg'] = XiusText::_('Publish/Unpublish list');

		return $data;
	}


	function saveOrder()
	{
		global $mainframe;

		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

 		$result = $this->_saveOrder($id,$direction);

		$mainframe->redirect( XiusRoute::_('index.php?option=com_xius&view=list',false),$result['msg']);
	}


	function _saveOrder($id , $direction)
	{
		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];

			// Load the JTable Object.
			$table	=& JTable::getInstance( 'list' , 'XiusTable' );

			$table->load( $id );

			if(!$table->move( $direction ))
				$data = array('msg' => $table->getError() , 'success' => false );
			else
				$data = array('msg' => XiusText::_('Ordered List') , 'success' => true );
		}
		else
			$data = array('msg' => XiusText::_('Not ordered') , 'success' => false );

		return $data;
	}
}
