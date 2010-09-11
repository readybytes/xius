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
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_MODEL,		'model',		'Xiussite');
XiusLoader::addAutoLoadViews (XIUS_PATH_SITE_VIEW,		JRequest::getCmd('format','html'),	'Xiussite');
XiusLoader::addAutoLoadFolder(XIUS_PATH_SITE_HELPER,	'helper',		'Xiussite');

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang){
	$lang->load(XIUS_COMPONENT_NAME);
	$lang->load( 'com_community' );
}
