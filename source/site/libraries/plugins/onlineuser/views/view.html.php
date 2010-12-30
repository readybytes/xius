<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

//require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class OnlineuserView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}	
	
	function searchHtml($calleObject)
    {
        if(!$calleObject->isAllRequirementSatisfy())
            return false;
            
        ob_start();
        $this->display('search');
        $contents = ob_get_clean();
        return $contents;
    }
}