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
define('XIUS_VERSION','@global.version@.@svn.lastrevision@');
//names which will not vary
define('XIUS_COMPONENT_NAME','com_xius');

//all folder paths
define('XIUS_COMPONENT_PATH_SITE',	JPATH_ROOT.DS.'components'.DS.XIUS_COMPONENT_NAME);
define('XIUS_COMPONENT_PATH_ADMIN',	JPATH_ADMINISTRATOR.DS.'components'.DS.XIUS_COMPONENT_NAME);
define('XIUS_PLUGINS_PATH',	XIUS_COMPONENT_PATH_SITE.DS.'libraries'.DS.'plugins');

//all folder paths define
define('XIUS_PATH_SITE_CONTROLLER',	XIUS_COMPONENT_PATH_SITE.DS.'controllers');
define('XIUS_PATH_SITE_MODEL',		XIUS_COMPONENT_PATH_SITE.DS.'models');
define('XIUS_PATH_SITE_VIEW',		XIUS_COMPONENT_PATH_SITE.DS.'views');
define('XIUS_PATH_SITE_HELPER',		XIUS_COMPONENT_PATH_SITE.DS.'helpers');

//XITODO:: change name formate
//admin
define('XIUS_TABLE_PATH',		XIUS_COMPONENT_PATH_SITE.DS.'tables');
define('XIUS_MODEL_PATH',		XIUS_COMPONENT_PATH_SITE.DS.'models');
define('XIUS_PATH_VIEW',		XIUS_COMPONENT_PATH_ADMIN.DS.'views');
define('XIUS_PATH_CONTROLLER',	XIUS_COMPONENT_PATH_ADMIN.DS.'controllers');

// Assets path
define('XIUS_ASSET_PATH',		XIUS_COMPONENT_PATH_SITE.DS.'assets');

//frontend
define('XIUS_PATH_LIBRARY',		XIUS_COMPONENT_PATH_SITE.DS.'libraries');
define('XIUS_PATH_BASE',		XIUS_PATH_LIBRARY.DS.'base');
define('XIUS_PATH_LIB',			XIUS_PATH_LIBRARY.DS.'lib');
define('XIUS_PATH_HELPER',		XIUS_COMPONENT_PATH_SITE.DS.'helpers');
define('XIUS_PATH_TEMPLATE',	XIUS_COMPONENT_PATH_SITE.DS.'templates');
define('XIUS_PATH_SITE_ASSET',	XIUS_COMPONENT_PATH_SITE.DS.'assets');


define('XIUS_ALL',-1);

define('XIUS_EQUAL','=');
define('XIUS_LT','<');
define('XIUS_GT','>');
define('XIUS_LIKE','LIKE');
define('XIUS_NOTLIKE','NOT LIKE');
define('XIUS_IN', 'IN');
define('XIUS_NOTIN', 'NOT IN');
define('XIUS_LTE', '<=');
define('XIUS_GTE', '>=');
define('XIUS_NOTEQUAL', '!=');

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

$version = new JVersion();
define('XIUS_JOOMLA_16',($version->RELEASE === '1.6'));
define('XIUS_JOOMLA_15',($version->RELEASE === '1.5'));
define('XIUS_JOOMLA_17',($version->RELEASE === '1.7'));

//Constant for joomla 1.5 Table field
if (XIUS_JOOMLA_15){
	define('XIUS_JOOMLA_EXT_ID','id');
	define('XIUS_JOOMLA_MENU_COMP_ID','componentid');
	define('XIUS_JOOMLA_GROUP_VALUE','value');
}
//Constant for joomla 1.6 Table field
else{
	define('XIUS_JOOMLA_EXT_ID','extension_id');
	define('XIUS_JOOMLA_MENU_COMP_ID','component_id');
	define('XIUS_JOOMLA_GROUP_VALUE','title');
}
