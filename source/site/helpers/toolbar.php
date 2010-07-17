<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusHelperToolbar 
{
	function getAdminToolbar($listid, $task)
	{
		$toolbar	= array();
		$obj 		= new stdClass();
		$url = JRoute::_("index.php?option=com_xius&view=users&task=displaySaveOption&tmpl=component&listid=".$listid);
		$obj->value = "<a class ='savelist' href='{$url}' rel = \"{handler: 'iframe', size: {x: 500 , y: 450}}\" >"
						."<img src='". JURI::base()."components/com_xius/assets/images/save.png' title='".JText::_("Save This List")."' /></a>";
		$toolbar['savelist'] = $obj;
		
		$obj 		= new stdClass();
		$csvurl = JRoute::_("index.php?option=com_xius&view=users&task=".$task."&subtask=xiusexport&format=csv");
		$obj->value	= "<img src='".JURI::base()."components/com_xius/assets/images/excel.png' onClick=\"location.href='".JRoute::_($csvurl,false)."'\" title='Export TO CSV' />";
		$toolbar['csv'] = $obj;
		$args = array();
		$args[]=& $toolbar;
		
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayResultToolbar', array($args) );
		
		return $toolbar;
	}	
}
