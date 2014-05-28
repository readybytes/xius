<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusText
{
	
	function sprintf($string)
	{
		$args = func_get_args();
		return call_user_func_array(array('JText','sprintf'), $args);
	}
    
	static function _($string, $jsSafe = false)
	{
    	$string='COM_XIUS_'.$string;
        return JText::_($string, $jsSafe);
    }
}