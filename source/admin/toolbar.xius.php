<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$view	= JRequest::getCmd('view','cpanel');

// Load submenu's				
$views	= array(
					'cpanel'	=> 'Home',
					'configuration'	=> 'Configuration',
					'info'		=> 'Information',
					'list' 		=> 'List'					
				);
				
foreach( $views as $key => $val )
{
	$active	= ( $view == $key );
	JSubMenuHelper::addEntry( $val , 'index.php?option=com_xius&view=' . $key , $active );
}
