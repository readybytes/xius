<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

// If file is already included
if(defined('XIUS_DEFINE'))
	return;

define('XIUS_DEFINE','XIUS_DEFINE');

//names which will not vary
define('XIUS_COMPONENT_NAME','com_xius');
	
//all folder paths
define('XIUS_COMPONENT_PATH_SITE',	JPATH_ROOT.DS.'components'.DS.XIUS_COMPONENT_NAME);
define('XIUS_COMPONENT_PATH_ADMIN',	JPATH_ADMINISTRATOR.DS.'components'.DS.XIUS_COMPONENT_NAME);
define('XIUS_PATH_TABLE',		XIUS_COMPONENT_PATH_ADMIN.DS.'tables');
define('XIUS_PATH_MODEL',		XIUS_COMPONENT_PATH_ADMIN.DS.'models');
define('XIUS_PATH_LIBRARY',		XIUS_COMPONENT_PATH_ADMIN.DS.'libraries');
define('XIUS_PATH_HELPER',		XIUS_COMPONENT_PATH_ADMIN.DS.'helpers');
define('XIUS_PATH_ASSET',		XIUS_COMPONENT_PATH_ADMIN.DS.'assets');

define('XIUS_ALL',-1);

define('XIUS_EQUAL','=');
define('XIUS_LT','<');
define('XIUS_GT','>');


define('XIUSSEARCH','SEARCH');
define('XIUSDEL','DELINFO');
define('XIUSSORT','SORT');


define('XIUS_CONDITIONS','conditions');
define('XIUS_SORT','sort');
define('XIUS_DIR','dir');
define('XIUS_JOIN','join');
