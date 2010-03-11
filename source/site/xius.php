<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/
defined('_JEXEC') or die();

require_once  dirname(__FILE__).DS.'includes'.DS.'includes.php';

//trigger system start event
XiecTriggerEvent('onSystemStart');

//no decide what to do
$view	= JRequest::getCmd('view', 		'dashboard');
$task 	= JRequest::getCmd('task', 		'display');
$format	= JRequest::getCmd('format',	'html');

//if it is an ajax call, call ajax methods in controller
if($format == 'ajax')
	$task = 'ajax'.JString::ucfirst($task);

// now we need to create a object of proper controller
$args['view'] 			= JString::strtolower($view);
$args['controllerClass']= 'Xiec'.JString::ucfirst(JString::strtolower($view)).'Controller';
$args['task'] 			= JString::strtolower($task);
$args['format'] 		= JString::strtolower($format);

// trigger apps, so that they can override the behaviour
// if somebody overrided it, then they must overwrite $data['controllerClass']
//in this case they must include the file, where class is defined
$results  =	XiecTriggerEvent('onControllerCreation', $args);

//we have setup autoloading for controller classes
//perform the task now
$controllerClass = $args['controllerClass'];
$controller = new $controllerClass();
$controller->execute($task);

//trigger system end event
XiecTriggerEvent('onSystemEnd');

$controller->redirect();