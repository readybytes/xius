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

JModel::addIncludePath(XIUS_MODEL_PATH);

require_once(XIUS_COMPONENT_PATH_SITE.DS.'libraries'.DS.'base'.DS.'loader.php');

// Autoload MVCT
XiusLoader::addAutoLoadFolder(XIUS_TABLE_PATH, 'table');
XiusLoader::addAutoLoadFolder(XIUS_PATH_CONTROLLER,	'controller');
XiusLoader::addAutoLoadFolder(XIUS_MODEL_PATH,		'model');
XiusLoader::addAutoLoadViews( XIUS_PATH_VIEW , 		JRequest::getCmd('format','html'));
XiusLoader::addAutoLoadFolder(XIUS_PATH_HELPER,		'Helper');

// Auto XiUS Plugin Helper classes
//XiusLoader::addAutoLoadPluginHelper(XIUS_PLUGINS_PATH, 'helper');

//Load libraray
//XiusLoader::addAutoLoadFolder(XIUS_PATH_LIBRARY,'');

// Auto-load Base folder
XiusLoader::addAutoLoadFolder(XIUS_PATH_BASE, '');


//Auto load lib folder
XiusLoader::addAutoLoadFolder(XIUS_PATH_LIB, 'Lib');

// auto load classes for base controller, base view,and modal
XiusLoader::addAutoLoadFile('XiusBase', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'base.php');
XiusLoader::addAutoLoadFile('XiusBaseView', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'baseview.php');



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
