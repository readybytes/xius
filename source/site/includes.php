<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

// If file is already included simply return
if(defined('XIUS_SITE_INCLUDES')) return;

define('XIUS_SITE_INCLUDES','XIUS_SITE_INCLUDES');

require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

// Frontend includes
//all folder paths
define('XIUS_PATH_SITE_CONTROLLER',	XIUS_COMPONENT_PATH_SITE.DS.'controllers');
define('XIUS_PATH_SITE_MODEL',		XIUS_COMPONENT_PATH_SITE.DS.'models');
define('XIUS_PATH_SITE_VIEW',		XIUS_COMPONENT_PATH_SITE.DS.'views');
define('XIUS_PATH_SITE_HELPER',		XIUS_COMPONENT_PATH_SITE.DS.'helpers');


XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_CONTROLLER,'controller',	'Xiussite');
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_MODEL,		'model');
XiusLoader::addAutoLoadViews (XIUS_PATH_SITE_VIEW,		JRequest::getCmd('format','html'),	'Xiussite');
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_HELPER,	'helper');

// Auto XiUS Plugin Helper classes
//XiusLoader::addAutoLoadPluginHelper(XIUS_PLUGINS_PATH, 'helper');

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
