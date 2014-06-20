<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperToolbar 
{
	public static function addToAdminToolbar($name='',$html='')
  	{
  		static $xiusToolbar = array();
  		
  		//already stored
  		if(isset($xiusToolbar[$name]) || $name==='')
  			return $xiusToolbar;
  			
  		$obj 			= new stdClass();
  		$obj->value		= $html;
  		
  		$xiusToolbar[$name]= $obj;
  		return $xiusToolbar; 
  	}

  }
