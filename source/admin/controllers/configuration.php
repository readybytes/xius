<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
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
		if(!JRequest::checkToken()) jexit( 'Invalid Token' );
				
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, XiusText::_('ACCESS FORBIDDEN') );
			return;
		}
		$method	= JRequest::getMethod();
		
		if( $method == 'GET' )
		{
			JError::raiseError( 500 , XiusText::_('ACCESS METHOD NOT ALLOWED') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiusFactory::getModel( 'configuration' );
		
		$xiusparams	= JRequest::getVar('xiusparams','','post');
		
		// Try to save configurations
		if( $cModel->save('config',$xiusparams) )
		{
			$message	= XiusText::_('CONFIGURATION UPDATED');
		}
		else
		{
			JError::raiseWarning( 100 , XiusText::_( 'UNABLE TO SAVE CONFIGURATION INTO DATABASE. PLEASE ENSURE THAT THE TABLE XIUS_CONFIG EXISTS' ) );
		}
		$link = XiusRoute::_('index.php?option=com_xius&view=configuration', false);
		$mainframe->redirect($link, $message);
	}
	
	function runCron()
	{
		global $mainframe;
		$link = XiusRoute::_('index.php?option=com_xius&view=configuration&task=display', false);
		$message = XiusText::_('CANT UPDATE CACHE NOW');
		
		$cModel = XiusFactory::getModel('configuration');
		$params	= $cModel->getParams();
		$xiusKey = $params->get('xiusKey','AB2F4');
		
		if(XiusHelpersUtils::verifyCronRunRequired($xiusKey) == false)
			$mainframe->redirect($link, $message);
	
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_START_TIME,$time);
		
		XiusLibrariesUsersearch::updateCache();
		
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_END_TIME,$time);
		
		$message = XiusText::_('CACHE UPDATED SUCCESSFULLY');
		$mainframe->redirect($link, $message);		
	}
	
	/*function reset()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$user	=& JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, XiusText::_('ACCESS FORBIDDEN') );
			return;
		}
		
		$mainframe	=& JFactory::getApplication();		

		$cModel	=& XiJCFactory::getModel( 'configuration' );
		
		// Try to save configurations
		if( $cModel->reset() )
		{
			$message = XiusText::_('CONFIGURATION HAS BEEN RESET TO DEFAULT SETTINGS');
		}
		else
		{
			JError::raiseWarning( 100 , XiusText::_( 'UNABLE TO RESET CONFIGURATION' ) );
		}
		$link = XiusRoute::_('index.php?option=com_xijc&view=configuration', false);
		$mainframe->redirect($link, $message);
	}	*/
}
