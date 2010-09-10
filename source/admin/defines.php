<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

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
define('XIUS_PATH_TEMPLATE',	XIUS_COMPONENT_PATH_SITE.DS.'templates');
define('XIUS_PATH_SITE_ASSET',	XIUS_COMPONENT_PATH_SITE.DS.'assets');

define('XIUS_ALL',-1);

define('XIUS_EQUAL','=');
define('XIUS_LT','<');
define('XIUS_GT','>');
define('XIUS_LIKE','LIKE');
define('XIUS_NOTLIKE','NOT LIKE');

define('XIUSSEARCH','SEARCH');
define('XIUSDEL','DELINFO');
define('XIUSSORT','SORT');

define('XIUS_LISTID','listid');
define('XIUS_CONDITIONS','conditions');
define('XIUS_VISIBLE','visible');
define('XIUS_SORT','sort');
define('XIUS_DIR','dir');
define('XIUS_JOIN','join');

define('XIUS_CACHE_START_TIME','cacheStartTime');
define('XIUS_CACHE_END_TIME','cacheEndTime');

define('XIUS_CRON_TIME_MULTIPLIER',5);
define('XIUS_MICRO_TO_SECOND',(1000*1000));

// Height and width of Pop up window for Saving List
define('XIUSLIST_IFRAME_HEIGHT', 200);
define('XIUSLIST_IFRAME_WIDTH', 400);
 