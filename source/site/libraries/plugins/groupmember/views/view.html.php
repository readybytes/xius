<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class GroupmemberView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function display($tmpl = null)
	{
		if(isset($this->info)){
			XiusError::assert($this->info,"AVAILABLE_INFO_ALLREADY_EXIST",2);
		}
		parent::display($tmpl);
	}
	
	/**
	 * Return HTMl data which have all groups
	 * @param $calleObject have GroupmemberView member object
	 */
	function searchHtml($calleObject, $value = '')
    {
        if(!$calleObject->isAllRequirementSatisfy()){
            return false;
        }
        // Get all groups name with id
       	$resultGroups =  XiusFactory::getInstance('model')
       					 ->getGroups();	
        	  					
       $this->assign('groups',$resultGroups);
       ob_start();
       $this->display('search');
       $contents = ob_get_clean();
       return $contents;
    }
}