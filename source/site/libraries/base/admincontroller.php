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

abstract class XiusAdminController extends JController
{
	function __construct($options = array())
	{
		parent::__construct();
	}
	
	
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)Controller/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiusController::getName() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/Controller(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "XiController : Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}


	public function getView($name='')
	{
		static $view = null;

		//XITODO : MUST check name of VIEW
		if($view)
			return $view;

		if(empty($name))
			$name 	= $this->getName();

		//get Instance from Factory
		$view	= 	XiusFactory::getInstance($name,'View', $this->getPrefix());

		if(!$view){
			JError::raiseError (500, XiusText::_("NOT ABLE TO GET INSTANCE OF VIEW : {$this->getName()}"));
			return null;
		}

		$layout	= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );		
		
		return $view;
	}
	
}