<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

// set module form name in seesion
$mySess =& JFactory::getSession();
$mySess->set('xiusModuleForm',"xiusMod{$module->id}",'XIUS');
		
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$url = 'index.php?option=com_xius&view=users&task=search';
if(XiusHelpersUtils::getConfigurationParams('integrateJomSocial',0) == true){
	$url = 'index.php?option=com_community&view=users&task=search&usexius=1';
}

$displayHtml= UserSearchHelper::getSearchHtml();
	if(!empty($displayHtml)):
		$link = $url;		
		$infoRange = $params->get('xius_info_range','all');
		$range=array();
		if( 'all' != strtolower($infoRange) ){
			$range = UserSearchHelper::getInfoRange($infoRange);
		}		

			$count=0;
			
	
	$mySess->clear('xiusModuleForm','XIUS');
	endif;
require(JModuleHelper::getLayoutPath('mod_xiussearchpanel'));
