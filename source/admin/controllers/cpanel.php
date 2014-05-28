<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 	support+joomlaxi@readybytes.in
 */
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
