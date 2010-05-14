<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

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
	
    function display() 
    {
		parent::display();
    }
	
	
	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$i = 1;
		if(!empty($ids))
		{
			foreach( $ids as $id )
			{
				$row	=& JTable::getInstance( 'list', 'XiusTable' );
			
				$row->load( $id );
				if(!$row->delete( $id ))
				{
					// If there are any error when deleting, we just stop and redirect user with error.
					$message	= JText::_('ERROR IN REMOVING LIST');
					$mainframe->redirect( 'index.php?option=com_xius&view=list' , $message);
					exit;
				}
				$i++;
			}
		}
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$message	= $count.' '.JText::_('LIST REMOVED');		
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
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
			return JError::raiseWarning( 500, JText::_( 'NO ITEMS SELECTED' ) );
		}
		
		$lModel =& XiusFactory::getModel('list');
		foreach($ids as $id)
			$lModel->updatePublish($id,1);
		
		$msg = $count. ' '. JText::_('ITEM PUBLISHED' );
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $msg); 
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
			return JError::raiseWarning( 500, JText::_( 'NO ITEMS SELECTED' ) );
		}
		
		$lModel =& XiusFactory::getModel('list');
		foreach($ids as $id)
			$lModel->updatePublish($id,0);
			
		$msg = $count.' '.JText::_('ITEM UNPUBLISHED' );
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $msg); 
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
			$table	=& JTable::getInstance( 'list' , 'XiusTable' );
		
			$table->load( $id );
			if(!$table->move( $direction ))
				$mainframe->enqueueMessage($table->getError());
			
			$mainframe->redirect( 'index.php?option=com_xius&view=list' );
		}
	}
}
