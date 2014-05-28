<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

//require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class OnlineuserView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}	
	
	function searchHtml($calleObject, $value = '')
    {
        if(!$calleObject->isAllRequirementSatisfy())
            return false;
            
        ob_start();
        $this->display('search');
        $contents = ob_get_clean();
        return $contents;
    }
}