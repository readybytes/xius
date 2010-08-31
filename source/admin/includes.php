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

$format	= JRequest::getCmd('format','html');
XiusLoader::addAutoLoadViews(XIUS_COMPONENT_PATH_SITE.DS.'views', $format,'Xiussite');

XiusLoader::addAutoLoadFolder(XIUS_PATH_MODEL,'model');
XiusLoader::addAutoLoadFolder(XIUS_COMPONENT_PATH_SITE.DS.'models','model');
XiusLoader::addAutoLoadFolder(XIUS_COMPONENT_PATH_SITE.DS.'helpers','helper');

XiusLoader::addAutoLoadFile('XiusCache', XIUS_PATH_LIBRARY.DS.'cache.php');
XiusLoader::addAutoLoadFile('XiusFactory', XIUS_PATH_LIBRARY.DS.'factory.php');
XiusLoader::addAutoLoadFile('XiusError', XIUS_PATH_LIBRARY.DS.'error.php');
XiusLoader::addAutoLoadFile('XiusQueryElement', XIUS_PATH_LIBRARY.DS.'query.php');
XiusLoader::addAutoLoadFile('XiusQuery', XIUS_PATH_LIBRARY.DS.'query.php');
XiusLoader::addAutoLoadFile('XiusCreateTable', XIUS_PATH_LIBRARY.DS.'query.php');

// auto load classes for base controller, base view,and modal
XiusLoader::addAutoLoadFile('XiusController', XIUS_PATH_LIBRARY.DS.'controller.php');
XiusLoader::addAutoLoadFile('XiusView', XIUS_PATH_LIBRARY.DS.'view.php');

XiusLoader::addAutoLoadFile('XiusBase', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'base.php');
XiusLoader::addAutoLoadFile('XiusBaseView', XIUS_PATH_LIBRARY.DS.'plugins'.DS.'baseview.php');

/*community files */
XiusLoader::addAutoLoadFile('CFactory', XIUS_PATH_LIBRARY.DS.'community.php');
//XiusLoader::addAutoLoadFile('CFactory', JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
XiusLoader::addAutoLoadFile('CAssets', XIUS_PATH_LIBRARY.DS.'community.php');
XiusLoader::addAutoLoadFile('CConfig', XIUS_PATH_LIBRARY.DS.'community.php');
XiusLoader::addAutoLoadFile('CApplications', XIUS_PATH_LIBRARY.DS.'community.php');
XiusLoader::addAutoLoadFile('CUser', XIUS_PATH_LIBRARY.DS.'community.php');
XiusLoader::addAutoLoadFile('CRoute', XIUS_PATH_LIBRARY.DS.'community.php');
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
