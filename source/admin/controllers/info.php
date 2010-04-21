<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiusControllerInfo extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		$this->registerTask( 'orderup' , 'saveOrder' );
		$this->registerTask( 'orderdown' , 'saveOrder' );
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
		$id = JRequest::getVar('editId', 0 );
		$plugin = JRequest::getVar('plugin', 0 ) ;
		
		$viewName	= JRequest::getCmd( 'view' , 'info' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		if(!$plugin && !$id) {
			$layout		= JRequest::getCmd( 'layout' , 'pluginlist' );
			$view->setLayout( $layout );
			echo $view->add($plugin);
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($id){
			
			$pluginObject = XiusFactory::getPluginInstanceFromId($id);
			if(!$pluginObject) {
				$layout		= JRequest::getCmd( 'layout' , 'pluginlist' );
				$view->setLayout( $layout );
				echo $view->add($plugin);
				return;
			}
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
	
	
	function _processSave()
	{
		//save aclparam and core param in individual columns
		// Test if this is really a post request
		$method	= JRequest::getMethod();
		$id = JRequest::getVar('editId', 0 );
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('ACCESS METHOD NOT ALLOWED') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();

		$post	= JRequest::get('post');
		
		jimport('joomla.filesystem.file');

		$infoTable	=& JTable::getInstance( 'info' , 'XiusTable' );
		$infoTable->load($post['id']);
				
		$data = array();
		
		$registry	=& JRegistry::getInstance( 'xius' );
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

		$isGotPluginData = $plgObject->collectParamsFromPost($data['key'],$data['pluginParams'],$post);
		
		$storedInfo = array();
		
		$id = XiusLibrariesInfo::infoExist($data);
		if($id && $data['id'] == 0){
			$storedInfo['id'] = $id;
			$storedInfo['msg'] = JText::_('INFO ALREADY EXIST');
			$infoTable->load($id);
			$data = (array) $infoTable;
		}
		else{
			$iModel	= XiusFactory::getModel( 'info' );
			$storedInfo['id'] = $iModel->save($data);
			
			
			if(!$storedInfo['id'])
				$storedInfo['msg'] = JText::_('ERROR IN SAVING INFO');
			else
				$storedInfo['msg'] = JText::_('INFO SAVED');
		}	

		$data['id'] = $storedInfo['id'];
		
		$info = array();
		$info['id'] = $storedInfo['id'];
		$info['data'] = $data;
		/*fork trigger */
		
		//JPluginHelper::importPlugin( 'system' );
		
		$dispatcher =& JDispatcher::getInstance();
		$results = $dispatcher->trigger( 'onUsInfoUpdated', array( $info ) );
			
		return $storedInfo;
	}
	
	function save()
	{
		$data = $this->_processSave();
		$link = JRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $data['msg']);		
		
	}
	
	function apply()
	{
		$data = $this->_processSave();
		$link = JRoute::_('index.php?option=com_xius&view=info&task=renderInfo&editId='.$data['id'], false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $data['msg']);				
	}	

	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		//$post['id'] = (int) $cid[0];
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'info' , 'XiusTable' );
		$i = 1;
		
		/*XITODO : check if info is used anywhere,
		 * if true , then don't delete it
		 */
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING INFO');
					$mainframe->redirect( 'index.php?option=com_xius&view=info' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('INFO REMOVED');		
		$link = JRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $message);
	}
	
	
	function publish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$iModel	= XiusFactory::getModel( 'info' );
		foreach($ids as $id)
		{
			$iModel->updatePublish($id,1);
		}
		$msg = JText::sprintf( $count.' ITEMS PUBLISHED' );
		$link = JRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	function unpublish()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		// Initialize variables
		$ids		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$count			= count( $ids );

		if (empty( $ids )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		
		$iModel	= XiusFactory::getModel( 'info' );
		foreach($ids as $id)
		{
			$iModel->updatePublish($id,0);
		}
		$msg = JText::sprintf( $count.' ITEMS UNPUBLISHED' );
		$link = JRoute::_('index.php?option=com_xius&view=info', false);
		$mainframe->redirect($link, $msg);
		return true;
	}
	
	
	
	function saveOrder()
	{
		global $mainframe;
	
		// Determine whether to order it up or down
		$direction	= ( JRequest::getWord( 'task' , '' ) == 'orderup' ) ? -1 : 1;

		// Get the ID in the correct location
 		$id			= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if( isset( $id[0] ) )
		{
			$id		= (int) $id[0];
			
			// Load the JTable Object.
			$table	=& JTable::getInstance( 'info' , 'XiusTable' );
		
			$table->load( $id );
			if(!$table->move( $direction ))
				$mainframe->enqueueMessage($table->getError());
			
			$mainframe->redirect( 'index.php?option=com_xius&view=info' );
		}
	}
	
}
