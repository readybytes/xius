<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

$value 	= $this->value;

 if(JFactory::getApplication()->isAdmin())
    echo xiusJoomlahelper::getUserGroupHtml('usertype[param][]', $value,true);
 else
    echo xiusJoomlahelper::getUserGroupHtml('usertype',$value, true);	
    
