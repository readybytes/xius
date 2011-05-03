<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/
// no direct access
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