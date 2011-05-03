<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

require_once  dirname(__FILE__).DS.'includes.php';

//now decide what to do
$view	= JRequest::getCmd('view', 		'cpanel');
$task 	= JRequest::getCmd('task', 		'display');
$format	= JRequest::getCmd('format',	'html');


//we assume that controller name will be after controller in admin
$controllerClass = 'Xius'.'Controller'.JString::ucfirst(JString::strtolower($view));

// Test if the object really exists in the current context
if(class_exists( $controllerClass,true)===false){
	JError::raiseError(500, sprintf(XiusText::_('INVALID_CONTROLLER_OBJECT_%s_CLASS_DEFINITION_DOES_NOT_EXISTE_IN_THIS_CONTEXT' ),$controllerClass));
}
//Import All XiuS plugins
JPluginHelper::importPlugin('xius');

$controller = new $controllerClass();
$controller->execute($task);
$controller->redirect();