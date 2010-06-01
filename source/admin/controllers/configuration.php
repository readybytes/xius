<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiusControllerConfiguration extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function display() 
	{
		parent::display();
    }

	
	function save()
	{
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
				
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('ACCESS FORBIDDEN') );
			return;
		}
		$method	= JRequest::getMethod();
		
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('ACCESS METHOD NOT ALLOWED') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiusFactory::getModel( 'configuration' );
		
		$xiusparams	= JRequest::getVar('xiusparams','','post');
		
		// Try to save configurations
		if( $cModel->save('config',$xiusparams) )
		{
			$message	= JText::_('CONFIGURATION UPDATED');
		}
		else
		{
			JError::raiseWarning( 100 , JText::_( 'UNABLE TO SAVE CONFIGURATION INTO DATABASE. PLEASE ENSURE THAT THE TABLE XIUS_CONFIG EXISTS' ) );
		}
		$link = JRoute::_('index.php?option=com_xius&view=configuration', false);
		$mainframe->redirect($link, $message);
	}
	
	
	/*function reset()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('ACCESS FORBIDDEN') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiJCFactory::getModel( 'configuration' );
		
		// Try to save configurations
		if( $cModel->reset() )
		{
			$message = JText::_('CONFIGURATION HAS BEEN RESET TO DEFAULT SETTINGS');
		}
		else
		{
			JError::raiseWarning( 100 , JText::_( 'UNABLE TO RESET CONFIGURATION' ) );
		}
		$link = JRoute::_('index.php?option=com_xijc&view=configuration', false);
		$mainframe->redirect($link, $message);
	}	*/
}
