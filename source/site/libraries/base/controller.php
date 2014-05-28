<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.application.component.view' );

class XiusController extends JControllerLegacy
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


	public function getView($name = '', $type = '', $prefix = '', $config = array())
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
