<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteHelperToolbar 
{
	static function addToAdminToolbar($name='',$html='')
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
