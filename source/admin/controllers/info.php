<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiusControllerInfo extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		$this->registerTask( 'orderup' , 'saveOrder' );
		$this->registerTask( 'orderdown' , 'saveOrder' );
		
		$this->registerTask( 'searchable' , 'saveParamDoable' );
		$this->registerTask( 'unsearchable' , 'saveParamDoable' );
		
		$this->registerTask( 'visible' , 'saveParamDoable' );
		$this->registerTask( 'invisible' , 'saveParamDoable' );
		
		$this->registerTask( 'sortable' , 'saveParamDoable' );
		$this->registerTask( 'unsortable' , 'saveParamDoable' );
		
		$this->registerTask( 'exportable' , 'saveParamDoable' );
		$this->registerTask( 'unexportable' , 'saveParamDoable' );
	}
	
    function display() 
	{
		parent::display();
    }
	
 
    function add()
	{
		$plugin = JRequest::getVar('plugin', 0 ) ;
		
		$viewName	= JRequest::getCmd( 'view' , 'info' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		if(!$plugin)
			$layout		= JRequest::getCmd( 'layout' , 'pluginlist' );
		else 
			$layout		= JRequest::getCmd( 'layout' , 'info.add' );
			
		$view->setLayout( $layout );

		echo $view->add($plugin);
	}
	
	
	function renderinfo()
	{
		$id 	  = JRequest::getVar('editId', 0 );
		$plugin   = JRequest::getVar('plugin', 0 ) ;
		$viewName = JRequest::getCmd( 'view' , 'info' );

		// Get the view type
		$viewType	= JFactory::getDocument()->getType();
		$view		= $this->getView( $viewName , $viewType );
		// XiTODO:: is it requrird
		if(!$plugin && !$id) {
			$layout	= JRequest::getCmd( 'layout' , 'pluginlist' );
			$view->setLayout( $layout );
			echo $view->add($plugin);
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($id){		
			$pluginObject = XiusFactory::getPluginInstance('',$id);
			
			if(!$pluginObject) {
				$layout		= JRequest::getCmd( 'layout' , 'pluginlist' );
				$view->setLayout( $layout );
				echo $view->add($plugin);
				return;
			}
			// XiTODO:: is it required
			$data = $pluginObject->toArray();
		}
		else if($plugin) {
			$pluginObject = XiusFactory::getPluginInstance($plugin);
			$data = $pluginObject->toArray();
		}
				
		
		$layout		= JRequest::getCmd( 'layout' , 'info.edit' );
		$view->setLayout( $layout );
		echo $view->renderinfo($pluginObject,$data);
	}
	
	
	function _processSave($post=null)
	{		
		if($post == null)
			$post	= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$infoTable	= XiusFactory::getInstance( 'info' , 'table');
		$infoTable->load($post['id']);
				
		$data = array();
		
		$registry	= new JRegistry;
		if(array_key_exists('isAccessible',$post['params'])){
			$temp 		= $post['params']['isAccessible'];
			$post['params']['isAccessible'] = serialize($temp);		
		}

		// trigger event before saving info
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnBeforeSaveInfo', array(&$post) );
		
		$registry->loadArray($post['params'],'xius_params');
		
		// Get the complete INI string
		$data['params']	= $registry->toString('INI' , 'xius_params' );
		
		$data['id'] 			= $post['id'];
		$data['pluginType'] 	= $post['pluginType'];
		$data['labelName'] 		= $post['labelName'];
		$data['published'] 		= $post['published'];
		
		unset($post['id']);
		unset($post['labelName']);
		unset($post['published']);
		unset($post['params']);
		
		$plgObject = XiusFactory::getPluginInstance($data['pluginType']);

		$plgObject->collectParamsFromPost($data['key'],$data['pluginParams'],$post);
		
		$storedInfo = array();
		
//		$id = XiusLibInfo::infoExist($data);
		$id =false;
		if($id && $data['id'] == 0){
			$storedInfo['id'] = $id;
			$storedInfo['msg'] = XiusText::_('INFO_ALREADY_EXIST');
			$infoTable->load($id);
			$data = (array) $infoTable;
		}
		else{
			$iModel	= XiusFactory::getInstance ( 'info','model' );
			$storedInfo['id'] = $iModel->save($data);
			
			
			if(!$storedInfo['id'])
				$storedInfo['msg'] = XiusText::_('ERROR_IN_SAVING_INFO');
			else
				$storedInfo['msg'] = XiusText::_('INFO_SAVED');
		}	

		$data['id'] = $storedInfo['id'];
		
		$info = array();
		$info['id'] = $storedInfo['id'];
		$info['data'] = $data;

		//reset cached information
		XiusLibInfo::getAllInfo(true);
		//Add new information in cache
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onUsInfoUpdated', array( $info ) );
			
		return $storedInfo;
	}
	
	function save()
	{
		//save aclparam and core param in individual columns
		// Test if this is really a post request
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS_METHOD_NOT_ALLOWED') );
			return;
		}
		
		$mainframe = JFactory::getApplication();
		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $data['msg']);		
		
	}
	
	function apply()
	{
		//save aclparam and core param in individual columns
		// Test if this is really a post request
		$method	= JRequest::getMethod();
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS_METHOD_NOT_ALLOWED') );
			return;
		}
		
		$mainframe = JFactory::getApplication();
		
		$data = $this->_processSave();
		$link = XiusRoute::_('index.php?option=com_xius&view=info&task=renderInfo&editId='.$data['id'], false);
		$mainframe->redirect($link, $data['msg']);				
	}	

	function remove()
	{
		$mainframe = JFactory::getApplication();
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );

		$data = $this->_remove();
		
		$cache = & JFactory::getCache('com_content');
		$cache->clean();	
		$link = XiusRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $data['message']);
	}
	
	
	function _remove($ids=null)
	{
		if($ids == null)
			$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		$count	= count($ids);

		$row = XiusFactory::getInstance ( 'info','table');
		
		
		/*XITODO : check if info is used anywhere,
		 * if true , then don't delete it
		 */
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
					$data['message']	= XiusText::_('ERROR_IN_REMOVING_INFO');
					return $data;
				}
			}
			
			$data['message'] = $count.' '.XiusText::_('INFO_REMOVED');	;
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
		
		$iModel	= XiusFactory::getInstance ( 'info', 'model' );
		foreach($ids as $id)
		{
			$iModel->updatePublish($id,1);
		}
		$msg = $count.XiusText::_('ITEMS_PUBLISHED' );
		$link = XiusRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	function unpublish()
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
		
		$iModel	= XiusFactory::getInstance ( 'info', 'model' );
		foreach($ids as $id)
		{
			$iModel->updatePublish($id,0);
		}
		$msg =  $count.XiusText::_('ITEMS_UNPUBLISHED' );
		$link = XiusRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	
	
	function saveOrder()
	{
		$mainframe = JFactory::getApplication();
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );
		
		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];
			
			// Load the JTable Object.
			$table	= XiusFactory::getInstance( 'info' , 'Table' );
		
			$table->load( $id );
			if(!$table->move( $direction ))
				$mainframe->enqueueMessage($table->getError());
			
			$mainframe->redirect( 'index.php?option=com_xius&view=info' );
		}
	}
	
	
	function saveParamDoable()
	{
		$mainframe = JFactory::getApplication();
		
		$link = XiusRoute::_('index.php?option=com_xius&view=info', false);		
		
		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );
		
		if( !isset( $id[0] ) )
			$mainframe->redirect($link, XiusText::_('PLEASE_SELECT_ANY_INFORMATION_TO_UPDATE'));	
		
		$id		= (int) $id[0];
		
		$subtask = JRequest::getWord( 'task' , '' );
		
		if($this->_saveParamDoable($id,$subtask))
			$msg = XiusText::_('PARAMS_UPDATED_SUCCESSFULLY');
		else
			$msg = XiusText::_('UNABLE_TO_SAVE_PARAMS');
			
		$mainframe->redirect($link, $msg);	
	}
	
	
	function _saveParamDoable($id,$subtask = null)
	{
		if($subtask == null)
			$subtask = JRequest::getWord( 'task' , '' );
		
		switch($subtask)
		{
			case 'searchable':
				$todo = 'isSearchable';
				$value = 1;
				break;
			case 'unsearchable':
				$todo = 'isSearchable';
				$value = 0;
				break;
			case 'visible':
				$todo = 'isVisible';
				$value = 1;
				break;
			case 'invisible':
				$todo = 'isVisible';
				$value = 0;
				break;
			case 'sortable':
				$todo = 'isSortable';
				$value = 1;
				break;
			case 'unsortable':
				$todo = 'isSortable';
				$value = 0;
				break;
			case 'exportable':
				$todo = 'isExportable';
				$value = 1;
				break;
			case 'unexportable':
				$todo = 'isExportable';
				$value = 0;
				break;
			default :
				$todo = '';
				$value = 0;
				break;
		}
		
		$iModel	= XiusFactory::getInstance ( 'info', 'model' );
		
		if($iModel->updateParams($id,$todo,$value))
			return true;
		
		return false;
	}
	
}
