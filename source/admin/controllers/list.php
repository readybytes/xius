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
	
    function display() 
    {
		parent::display();
    }
	
	
	function remove()
	{
		global $mainframe;
		// Check for request forgeries
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
		
		$data = $this->_remove();
				
		$cache = & JFactory::getCache('com_content');
		$cache->clean();
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
		$mainframe->redirect($link, $data['message']);
	}
	
	
	function _remove($ids=null)
	{
		if($ids == null)
			$ids	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
	
		$count	= count($ids);
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'list', 'XiusTable' );
		
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
					$data['message']	= JText::_('ERROR IN REMOVING LIST').' '. $id;
					return $data;
				}
			}
			
			$data['message'] = $count.' '.JText::_('LIST REMOVED');	;
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
			return JError::raiseWarning( 500, JText::_( 'NO ITEMS SELECTED' ) );
		}
		
		$result = $this->_updatePublish(1,$ids);

		if($result['success'])
			$msg = $count.' '.JText::_('ITEM UNPUBLISHED' );
		else
			$msg = JText::_('Unable to unblish list');
		
		$msg = $count. ' '. JText::_('ITEM PUBLISHED' );
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
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
			return JError::raiseWarning( 500, JText::_( 'NO ITEMS SELECTED' ) );
		}
		
		$result = $this->_updatePublish(0,$ids);

		if($result['success'])
			$msg = $count.' '.JText::_('ITEM UNPUBLISHED' );
		else
			$msg = JText::_('Unable to unblish list');
			
		$link = JRoute::_('index.php?option=com_xius&view=list', false);
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
		
		$lModel =& XiusFactory::getModel('list');
		foreach($ids as $id)
			if(!$lModel->updatePublish($id,$value)){
				$data['msg'] = JText::_('Unable to publish/unpublish list');
				return $data;
			}
				
		$data['success'] = true;
		$data['msg'] = JText::_('Publish/Unpublish list');
		
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
 		
		$mainframe->redirect( JRoute::_('index.php?option=com_xius&view=list',false),$result['msg']);
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
				$data = array('msg' => JText::_('Ordered List') , 'success' => true );	
		}
		else
			$data = array('msg' => JText::_('Not ordered') , 'success' => false );
			
		return $data;
	}
}
