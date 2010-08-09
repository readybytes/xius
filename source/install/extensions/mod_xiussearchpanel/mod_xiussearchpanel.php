<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// XITODO : move css stament to tmpl 
if(!defined('_JEXEC')) die('Restricted access');
$document =& JFactory::getDocument();
if ($params->get('xius_layout','horizontal')=='vertical')
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_ver.css');
else
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_hz.css');
	
// set module form name in seesion
$mySess =& JFactory::getSession();
$mySess->set('xiusModuleForm',"xiusMod{$module->id}",'XIUS');


		
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );
//XITODO : use proper name
$displayHtml= UserSearchHelper::getSearchHtml();
	if(!empty($displayHtml)):
		$link = 'index.php?option=com_xius&view=users&supplytask=displayresult';
		$menu = &JSite::getMenu(); 
		$itemid = $menu->getItems('link', $link);
		if(empty($itemid)){
			$itemid = $menu->getItems('link', "index.php?option=com_xius&view=users&layout=lists&task=displayList");
		}

		if(!empty($itemid)){
			$link .= "&Itemid=".$itemid[0]->id;
		}	

		$infoRange = $params->get('xius_info_range','all');
		$range=array();
		if( 'all' != strtolower($infoRange) ){
			$range = UserSearchHelper::getInfoRange($infoRange);
		}		

			$count=0;
			
	
	$mySess->clear('xiusModuleForm','XIUS');
	endif;
require(JModuleHelper::getLayoutPath('mod_xiussearchpanel'));
