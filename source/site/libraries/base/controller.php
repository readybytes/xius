<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
/**
 */

abstract class XiusController extends XiusAdmincontroller
{
	function __construct($options = array())
	{
		parent::__construct();
	}
	
	function execute( $task )
	{
		$plugin	= JRequest::getCmd('plugin',	'');
		if($plugin != ''){
			$pInst = XiusFactory::getPluginInstance($plugin);
			
			if($pInst == false)
				JError::raiseError( 500 , sprintf(XiusText::_('Invalid XIUS Plugin Object %s. Class definition does not exists in this context.' )));

			$controllerClass = 'Xius'.'PluginController'.JString::ucfirst(JString::strtolower($plugin));
			$controller = $pInst->getController($controllerClass);
			if($controller == false)
				JError::raiseError( 500 , sprintf(XiusText::_('Invalid Plugin Controller Object %s. Class definition does not exists in this context.' ),$controller));

			$controller->execute($task);
			$controller->redirect();
			return;
		}
		
		parent::execute($task);
	}

}