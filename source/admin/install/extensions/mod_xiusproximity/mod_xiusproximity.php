<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

// set module form name in seesion
$mySess = JFactory::getSession();
$mySess->set('xiusModuleForm',"xiusMod{$module->id}",'XIUS');
$mySess->set('xiusModuleName',"{$module->module}",'XIUS');

require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$link = 'index.php?option=com_xius&view=users&task=search';
if(XiusHelperUtils::getConfigurationParams('integrateJomSocial',0) == true){
	$link = 'index.php?option=com_community&view=users&task=search&usexius=1';
}

//setting params in helper function
$moduleParam= ModXiusProximity::setModuleParams($params);

//collect HTML for fields
$displayProximity= ModXiusProximity::getProximityHtml($params);
$displayKeyword= ModXiusProximity::getKeywordHtml();

//clear the session
$mySess->clear('xiusModuleForm','XIUS');
$mySess->clear('xiusModuleName','XIUS');
	
// render fields
require(JModuleHelper::getLayoutPath('mod_xiusproximity'));
