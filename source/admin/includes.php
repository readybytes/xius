<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 	support+joomlaxi@readybytes.in
 */
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
