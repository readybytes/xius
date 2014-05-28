<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Module
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// If Xius System Plugin disabled then do nothing
$state = JPluginHelper::isEnabled('system', 'xius_system');
if(!$state){
    return true;
}

// set module form name in seesion
$mySess = JFactory::getSession();
$mySess->set('xiusModuleForm',"xiusMod{$module->id}",'XIUS');
		
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$link = 'index.php?option=com_xius&view=users&task=search';
if(XiusHelperUtils::getConfigurationParams('integrateJomSocial',0) == true){
	$link = 'index.php?option=com_community&view=users&task=search&usexius=1';
}
XiusHelperUtils::loadJomsJquery();
$infoRange = $params->get('xius_info_range','all');
$infoRange = explode(",",$infoRange);
$displayInfo = Array();
foreach($infoRange as $range){
	$formateRange   = UserSearchHelper::getInfoRange($range);
	$searchInfo     = UserSearchHelper::getSearchHtml($formateRange);
	//Hope this code will not generate any issue. (Like foreach ($infoValue as $value), issue getting by $value when resuse it after foreach. ) 
	foreach ($searchInfo as $info)
		array_push($displayInfo, $info);
}
if(empty($displayInfo)){
	echo XiusText::_("SEARCHABLE_INFORMATION_ARE_NOT_AVAILABLE");
	return ;
} 

$dispatcher = JDispatcher::getInstance();
$dispatcher->trigger('onBeforeDisplaySearchPanel',array(null));
$mySess->clear('xiusModuleForm','XIUS');

require(JModuleHelper::getLayoutPath('mod_xiussearchpanel'));
