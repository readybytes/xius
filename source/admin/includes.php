<?php

/*
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

// If file is already included
if(defined('XIUS_ADMIN_INCLUDES'))
	return;

define('XIUS_ADMIN_INCLUDES','XIUS_ADMIN_INCLUDES');

//XITODO : add autoloading, do not just includes
//include basic required files
jimport('joomla.utilities.string');
jimport( 'joomla.filesystem.files' );
jimport( 'joomla.filesystem.folders' );

//load basic defines
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'defines.php';

jimport( 'joomla.application.component.controller' );
jimport('joomla.application.component.model');
JModel::addIncludePath(XIUS_PATH_MODEL);
JTable::addIncludePath(XIUS_PATH_TABLE);

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'loader.php');

XiusLoader::addAutoLoadFolder(XIUS_PATH_HELPER,'Helpers');
XiusLoader::addAutoLoadFolder(XIUS_PATH_LIBRARY,'Libraries');

XiusLoader::addAutoLoadFile('XiusCache', XIUS_PATH_LIBRARY.DS.'cache.php');
XiusLoader::addAutoLoadFile('XiusFactory', XIUS_PATH_LIBRARY.DS.'factory.php');
XiusLoader::addAutoLoadFile('XiusError', XIUS_PATH_LIBRARY.DS.'error.php');
XiusLoader::addAutoLoadFile('XiusQueryElement', XIUS_PATH_LIBRARY.DS.'query.php');
XiusLoader::addAutoLoadFile('XiusQuery', XIUS_PATH_LIBRARY.DS.'query.php');

XiusLoader::addAutoLoadFile('XiusBase', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'base.php');
XiusLoader::addAutoLoadFile('XiusBaseView', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'baseview.php');

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang)
	$lang->load( 'com_xius' );
