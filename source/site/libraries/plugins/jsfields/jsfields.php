<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once dirname(__FILE__).DS.'base.php';
$jsVersion  = XiusHelperUtils::getJSVersion();
$pluginPath = dirname(__FILE__).DS; 
$name = 'jsfields20';
if(JString::stristr($jsVersion, '1.8')){
	$name = 'jsfields18';
}

require_once $pluginPath.$name.'.php';
