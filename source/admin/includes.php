<?php

/*
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

//include basic required files
jimport('joomla.utilities.string');

//load basic defines
require_once dirname(__FILE__).DS.'defines.php'	;

//load basic helpers
require_once XIEC_PATH_HELPER .DS.'loader.php'	;

//import core classes, these classes will always be inherited
//there fore we need to preload these
XiHelperLoader::includeFolder(XIEC_PATH_HELPER);

XiHelperLoader::addAutoLoadFolder(XIEC_PATH_LIBRARY.DS.'base','Xi','');

// setup autoloading for classes
XiHelperLoader::addAutoLoadFolder(XIEC_PATH_MODEL, 		'Model');
XiHelperLoader::addAutoLoadFolder(XIEC_PATH_CONTROLLER,	'Controller');
XiHelperLoader::addAutoLoadFolder(XIEC_PATH_VIEW, 		'View');
XiHelperLoader::addAutoLoadFolder(XIEC_PATH_TABLE,		'Table');

//Other folders should be added here as we need those
//XiHelperLoader::addAutoLoadFolder(XIEC_PATH_COMPONENT_SITE.DS.'libraries'.DS.'payments', 'XiModel');


//load basic utilities which we need every where