<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once dirname(__FILE__).DS.'base.php';
$jsVersion  = XiusHelperUtils::getJSVersion();
$pluginPath = dirname(__FILE__).DS; 
if(JString::stristr($jsVersion, '2.0'))
	$name = 'jsfields20';
else
	$name = 'jsfields18';

require_once $pluginPath.$name.'.php';
