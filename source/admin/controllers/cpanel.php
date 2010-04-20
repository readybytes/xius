<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiusControllerCpanel extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
    

    function updates()
	{
		$viewName	= JRequest::getCmd( 'view' , 'cpanel' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'mainupdates' );
		$view->setLayout( $layout );
		
		echo $view->updates();
	}
		
}
