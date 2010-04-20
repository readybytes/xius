<?php

defined('_JEXEC') or die();

require_once  dirname(__FILE__).DS.'includes.php';

if(JRequest::getCmd('view') == '') 
	JRequest::setVar('view', 'cpanel');
	

//now decide what to do
$view	= JRequest::getCmd('view', 		'cpanel');
$task 	= JRequest::getCmd('task', 		'display');
$format	= JRequest::getCmd('format',	'html');

$path	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.strtolower($view).'.php';

// Test if the controller really exists
if(file_exists($path))
	require_once( $path );
else
	JError::raiseError( 500 , sprintf(JText::_( 'Invalid Controller %s. File does not exists in this context.' ),$view) );

//we assume that controller name will be after controller in admin
$controllerClass = 'Xius'.'Controller'.JString::ucfirst(JString::strtolower($view));

// Test if the object really exists in the current context
if( class_exists( $controllerClass ) )
	$controller = new $controllerClass();
else
	JError::raiseError( 500 , sprintf(JText::_('Invalid Controller Object %s. Class definition does not exists in this context.' ),$controllerClass));

$controller->execute($task);

$controller->redirect();