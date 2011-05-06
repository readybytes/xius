<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

require_once  dirname(__FILE__).DS.'includes.php';


//now decide what to do
$view	= JRequest::getCmd('view', 		'users');
$task 	= JRequest::getCmd('task', 		'panel');
$format	= JRequest::getCmd('format',	'html');

$controllerClass = 'Xiussite'.'Controller'
				  .JString::ucfirst(JString::strtolower($view));

// Test if the object really exists in the current context
if(class_exists( $controllerClass,true)===false)
	JError::raiseError( 500 , sprintf(XiusText::_('INVALID_CONTROLLER_OBJECT %s CLASS_DEFINITION_DOES_NOT_EXISTS_IN_THIS_CONTEXT' ),$controllerClass));

$controller = new $controllerClass();
$controller->execute($task);
$controller->redirect();