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
$plugin	= JRequest::getCmd('plugin',	'');
$path		= JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.JString::strtolower($view).'.php';

// Test if the controller really exists
if(file_exists($path))
	require_once( $path );
else
	JError::raiseError( 500 , sprintf(XiusText::_( 'Invalid Controller %s. File does not exists in this context.' ),$view) );

/*IMP : discard this assumption b'coz view name always set after View 
*we assume that controller name will be before , 'controller' in front
*/
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
	
$controllerClass = 'Xiussite'.'Controller'.JString::ucfirst(JString::strtolower($view));


// Test if the object really exists in the current context
if( class_exists( $controllerClass ) )
	$controller = new $controllerClass();
else
	JError::raiseError( 500 , sprintf(XiusText::_('Invalid Controller Object %s. Class definition does not exists in this context.' ),$controllerClass));

$controller->execute($task);

$controller->redirect();