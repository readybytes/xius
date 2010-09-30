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

//XITODO : add autoloading, do not just includes
//include basic required files
jimport('joomla.utilities.string');
jimport('joomla.filesystem.files' );
jimport('joomla.filesystem.folders' );
jimport('joomla.application.component.controller' );
jimport('joomla.application.component.model');

//load basic defines
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'defines.php';

JModel::addIncludePath(XIUS_PATH_MODEL);

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'loader.php');

// Autoload MVCT
XiusLoader::addAutoLoadFolder(XIUS_PATH_TABLE, 'table');
XiusLoader::addAutoLoadFolder(XIUS_PATH_CONTROLLER,	'controller');
XiusLoader::addAutoLoadFolder(XIUS_PATH_MODEL,		'model');
XiusLoader::addAutoLoadViews( XIUS_PATH_VIEW , 		JRequest::getCmd('format','html'));
XiusLoader::addAutoLoadFolder(XIUS_PATH_HELPER,		'helpers');

//Load libraray
XiusLoader::addAutoLoadFolder(XIUS_PATH_LIBRARY,'');

//Add explicit files XITODO : Add them in auto loading
XiusLoader::addAutoLoadFile('XiusRoute', XIUS_PATH_LIBRARY.DS.'route.php');
XiusLoader::addAutoLoadFile('XiusQueryElement', XIUS_PATH_LIBRARY.DS.'queryelement.php');
XiusLoader::addAutoLoadFile('XiusCreateTable', XIUS_PATH_LIBRARY.DS.'createtable.php');
XiusLoader::addAutoLoadFile('XiusLibrariesInfo', XIUS_PATH_LIBRARY.DS.'info.php');
XiusLoader::addAutoLoadFile('XiusLibrariesList', XIUS_PATH_LIBRARY.DS.'list.php');
XiusLoader::addAutoLoadFile('XiusLibrariesPluginhandler', XIUS_PATH_LIBRARY.DS.'pluginhandler.php');
XiusLoader::addAutoLoadFile('XiusLibrariesUsersearch', XIUS_PATH_LIBRARY.DS.'usersearch.php');


// auto load classes for base controller, base view,and modal
XiusLoader::addAutoLoadFile('XiusBase', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'base.php');
XiusLoader::addAutoLoadFile('XiusBaseView', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'baseview.php');

XiusLoader::addAutoLoadFile('XiusAdminController', XIUS_PATH_LIBRARY.DS.'admincontroller.php');

/*JomSocial community files */
foreach(array('CFactory','CAssets','CConfig','CApplications','CUser','CRoute') as $className)
	XiusLoader::addAutoLoadFile($className, XIUS_PATH_LIBRARY.DS.'community.php');

//Explicit JomSocial Dependency
CConfig::getInstance();
XiusLoader::addAutoLoadFile('CMessaging', JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'messaging.php');
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang){
	$lang->load( 'com_xius' );
	$lang->load( 'com_community' );
}