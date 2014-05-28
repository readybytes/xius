<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$value 	= $this->value;

 if(JFactory::getApplication()->isAdmin())
    echo xiusJoomlahelper::getUserGroupHtml('usertype[param][]', $value,true);
 else
    echo xiusJoomlahelper::getUserGroupHtml('usertype',$value, true);	
    
