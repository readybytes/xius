<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

// If file is already included
if(defined('XIEC_DEFINE'))
	return;

define('XIEC_PATH_COMPONENT_SITE', dirname(dirname(__FILE__)));

//required for testing
if(!defined('JPATH_COMPONENT'))
define( 'JPATH_COMPONENT',	XIEC_PATH_COMPONENT_SITE);
		
//all folder paths
define('XIEC_PATH_TABLE',		XIEC_PATH_COMPONENT_SITE.DS.'tables');
define('XIEC_PATH_MODEL',		XIEC_PATH_COMPONENT_SITE.DS.'models');
define('XIEC_PATH_CONTROLLER',	XIEC_PATH_COMPONENT_SITE.DS.'controllers');
define('XIEC_PATH_VIEW',		XIEC_PATH_COMPONENT_SITE.DS.'views');
define('XIEC_PATH_LIBRARY',		XIEC_PATH_COMPONENT_SITE.DS.'libraries');
define('XIEC_PATH_HELPER',		XIEC_PATH_COMPONENT_SITE.DS.'helpers');
define('XIEC_PATH_INCLUDE',		XIEC_PATH_COMPONENT_SITE.DS.'includes');
define('XIEC_PATH_MEDIA',		XIEC_PATH_COMPONENT_SITE.DS.'media');

//names which will not vary
define('XIEC_COMPONENT_NAME','com_xiec');

//regarding states
define('XI_STATE_BOUND_LOWER',	'bound.lower');
define('XI_STATE_BOUND_UPPER',	'bound.upper');
define('XI_STATE_LIKE',			'like');
define('XI_STATE_EQUAL',		'equal');
