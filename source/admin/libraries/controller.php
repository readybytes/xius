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

abstract class XiusController extends JController
{
	protected	$_prefix	= '';
	//Absolute prefix contain component name , irrespective of site or admin
	protected	$_absolutePrefix	= 'xiec';
	protected	$_tpl		= null;

	//it stores relation between task and table column
	// _boolMap[TASKNAME]= array( TABLE COLUMN, CHANGE VALUE, SWITCH)
	protected 	$_boolMap	= array();
	/**
	 * Publish/Ordering functionality can be common on various forms
	 * If child class want to differ, then it can over-ride, savePublish or saveOrder
	 */
	function __construct($options = array())
	{
		parent::__construct();

		//init the controller
		//$this->_addTaskMapping();
	}	
	
/*
	 * Collect prefix auto-magically
	 */
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
		
		if($view)
			return $view;
			
		if(empty($name))
			$name 	= $this->getName();

		//get Instance from Factory
		$view	= 	XiusFactory::getInstance($name,'View', $this->getPrefix());

		if(!$view){
			$this->setError(XiusText::_("NOT ABLE TO GET INSTANCE OF VIEW : {$this->getName()}"));
		}
		
		$layout	= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );
		
		/*
		 *  if external URL is set in controller then also set it into view also
		 */
		$view->_isExternalUrl = $this->_isExternalUrl;  
		return $view;
	}	
}