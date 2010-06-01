<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

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
