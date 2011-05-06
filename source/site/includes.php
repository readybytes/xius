<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

// If file is already included simply return
if(defined('XIUS_SITE_INCLUDES')) return;

define('XIUS_SITE_INCLUDES','XIUS_SITE_INCLUDES');

//require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

//include basic required files
jimport('joomla.utilities.string');
jimport('joomla.filesystem.files' );
jimport('joomla.filesystem.folders' );
jimport('joomla.application.component.controller' );
jimport('joomla.application.component.model');

//Import All XiuS plugins
JPluginHelper::importPlugin('xius');

//load basic defines
require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'defines.php';

//set Model Path into (includePath) 
JModel::addIncludePath(XIUS_MODEL_PATH);
// For auto-loading purpose
require_once(XIUS_COMPONENT_PATH_SITE.DS.'libraries'.DS.'base'.DS.'loader.php');

// Auto-load Base folder
XiusLoader::addAutoLoadFolder(XIUS_PATH_BASE, '');

//Auto load lib folder
XiusLoader::addAutoLoadFolder(XIUS_PATH_LIB, 'Lib');

// auto load classes for base controller, base view,and modal
XiusLoader::addAutoLoadFile('XiusBase', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'base.php');
XiusLoader::addAutoLoadFile('XiusBaseView', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'baseview.php');


// Auto Load Model And Helper Classes
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_MODEL,		'model');
XiusLoader::addAutoLoadFolder(XIUS_TABLE_PATH, 'table');
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_HELPER,	'helper');

// Auto-Load site Controller And View
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_CONTROLLER,'controller',	'Xiussite');
XiusLoader::addAutoLoadViews (XIUS_PATH_SITE_VIEW,		JRequest::getCmd('format','html'),	'Xiussite');


/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang){
	$lang->load(XIUS_COMPONENT_NAME);
	$lang->load( 'com_community' );
}

// Autoloading for Jom social 2.0 [ Zend Plugin ]
$paths	= explode( PATH_SEPARATOR , get_include_path() );

if( !in_array( JPATH_ROOT . DS . 'plugins' . DS . 'system', $paths ) )
{
	set_include_path('.'
	    . PATH_SEPARATOR . JPATH_ROOT.DS.'plugins'.DS.'system'
	    . PATH_SEPARATOR . get_include_path()
	);
}

if(JFile::exists(JPATH_ROOT . DS.'plugins'.DS.'system'.DS.'Zend/Loader/Autoloader.php'))
{
	//check if zend plugin is enalble.
	$zend = JPluginHelper::getPlugin('system', 'zend');	
	if(!empty($zend) && !class_exists('Zend_Loader'))
	{
		// Only include the zend loader if it has not been loaded first
		include_once(JPATH_ROOT . DS.'plugins'.DS.'system'.DS.'Zend/Loader/Autoloader.php');
		// register auto-loader
		$loader = Zend_Loader_Autoloader::getInstance();
	}
}
//it must be after Zend_Loader_Autoloader 
/*JomSocial community files */
foreach(array('CFactory','CAssets','CConfig','CApplications','CUser','CRoute') as $className)
	XiusLoader::addAutoLoadFile($className, XIUS_PATH_LIBRARY.DS.'community.php');

//Explicit JomSocial Dependency
CConfig::getInstance();
XiusLoader::addAutoLoadFile('CMessaging', JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'messaging.php');
XiusLoader::addAutoLoadFile('CFriends', JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'friends.php');
require_once JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'defines.community.php';

