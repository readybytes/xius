<?php

/*
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die('Restricted access');

// If file is already included
if(defined('XIUS_SITE_INCLUDES'))
	return;

define('XIUS_SITE_INCLUDES','XIUS_SITE_INCLUDES');

require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

/*Load Langauge file*/
$lang =& JFactory::getLanguage();
if($lang){
	$lang->load( 'com_xius' );
	$lang->load( 'com_community' );
}
