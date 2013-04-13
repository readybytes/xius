<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

// If file is already included
if(defined('XIUS_ADMIN_INCLUDES'))
	return;

define('XIUS_ADMIN_INCLUDES','XIUS_ADMIN_INCLUDES');

// It must::use requir_once After "XIUS_ADMIN_INCLUDES" define
require_once  JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';

// Autoload Admin Controller and View
XiusLoader::addAutoLoadFolder(XIUS_PATH_CONTROLLER,	'controller');
XiusLoader::addAutoLoadViews( XIUS_PATH_VIEW , 		JRequest::getCmd('format','html'));
