<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiusControllerCpanel extends XiusController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
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
