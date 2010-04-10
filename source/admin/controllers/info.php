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
		$viewName	= JRequest::getCmd( 'view' , 'info' );
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		
		$view		=& $this->getView( $viewName , $viewType );
		
		$layout		= JRequest::getCmd( 'layout' , 'info.add' );
			
		$view->setLayout( $layout );

		echo $view->add();
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
			$layout		= JRequest::getCmd( 'layout' , 'info.add' );
			$view->setLayout( $layout );
			echo $view->add();
			return;
		}
		
		$data = array();
		$data['id'] = $id;
		
		if($id){
			
			$pluginObject = XiusFactory::getPluginInstanceFromId($id);
			if(!$pluginObject) {
				$layout		= JRequest::getCmd( 'layout' , 'info.add' );
				$view->setLayout( $layout );
				echo $view->add();
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
		echo $view->renderinfo($data);
	}
	
	
	function processSave()
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

		$aclTable	=& JTable::getInstance( 'aclrules' , 'XiPTTable' );
		$aclTable->load($post['id']);
				
		$data = array();
		
		$registry	=& JRegistry::getInstance( 'xipt' );
		$registry->loadArray($post['coreparams'],'xipt_coreparams');
		// Get the complete INI string
		$data['coreparams']	= $registry->toString('INI' , 'xipt_coreparams' );
		
		$data['id'] 			= $post['id'];
		$data['aclname'] 		= $post['aclname'];
		$data['rulename']	 	= $post['rulename'];
		$data['published'] 		= $post['published'];
		
		unset($post['id']);
		unset($post['rulename']);
		unset($post['aclname']);
		unset($post['published']);
		unset($post['coreparams']);
		
		$aclObject = aclFactory::getAclObject($data['aclname']);
		$data['aclparams'] = $aclObject->collectParamsFromPost($post);
		
		
		$aclTable->bind($data);
		$data = array();
		// Save it
		if(! ($data['id'] = $aclTable->store()) )
			$data['msg'] = JText::_('ERROR IN SAVING RULE');
		else
			$data['msg'] = JText::_('RULE SAVED');	

		return $data;
	}
	
	function save()
	{
		$data = $this->processSave();
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
		$mainframe	=& JFactory::getApplication();
		$mainframe->redirect($link, $data['msg']);		
		
	}
	
	function apply()
	{
		$data = $this->processSave();
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules&task=renderacl&editId='.$data['id'], false);
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
		$row	=& JTable::getInstance( 'aclrules' , 'XiPTTable' );
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING RULE');
					$mainframe->redirect( 'index.php?option=com_xipt&view=aclrules' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('RULE REMOVED');		
		$link = JRoute::_('index.php?option=com_xipt&view=aclrules', false);
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