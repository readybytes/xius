<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class XiusController extends JController
{
	function __construct($options = array())
	{
		parent::__construct();
	}
	
	function execute( $task )
	{
		$plugin	= JRequest::getCmd('plugin',	'');

		if($plugin != '')
		{
			$pluginInstance = XiusFactory::getPluginInstance($plugin);
			// Error:: When Not get Plugin instance
			XiusError::assert($pluginInstance);
			$controllerClass = 'Xius'.'PluginController'.JString::ucfirst(JString::strtolower($plugin));
			$controller 	 = $pluginInstance->getController($controllerClass);
			
			XiusError::assert($controller, "Invalid Plugin Controller Object $controllerClass Class definition does not exists in this context.", 1);

			$controller->execute($task);
			$controller->redirect();
			return;
		}
		
		parent::execute($task);
	}
	
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false){
			return $this->_prefix;
		}
		
		$temp = null;
		XiusError::assert (preg_match('/(.*)Controller/i', get_class($this), $temp), "Can't get or parse ".XiusController::getName());
		$this->_prefix  =  JString::strtolower($temp[1]);
		return $this->_prefix;
	}

	function getName()
	{
		if (empty( $this->_name))
		{
			$temp = null;
			XiusError::assert (preg_match('/Controller(.*)/i', get_class($this), $temp), "Can't get or parse XiusController::getName()");			
			$this->_name = strtolower( $temp[1] );
		}
		return $this->_name;
	}


	public function getView($name='')
	{
		static $view = null;

		if(empty($name)){
			$name 	= $this->getName();
		}

		if($view && $view->getName() == $name){
			return $view;
		}

		//get Instance from Factory
		$view	= XiusFactory::getInstance($name,'View', $this->getPrefix());
		$layout	= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );		
		return $view;
	}
}
