<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperToolbar 
{
	function getAdminToolbar($listid, $task)
	{
		$toolbar	= array();
		$user = JFactory::getUser();		
		
		$args = array();
		$args[]=& $toolbar;		
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayResultToolbar', array($args) );
		
		// if logged in user's user type is in list creator user type 
		//then he will be having the option of saving and exporting list
		
		$listCreator = unserialize(XiusHelpersUtils::getConfigurationParams('xiusListCreator','a:1:{i:0;s:19:"Super Administrator";}'));
 		if(XiusHelperList::isAccessibleToUser($user,$listCreator)){
  			$obj 		= new stdClass();
  			$url = JRoute::_("index.php?option=com_xius&view=list&task=saveas&tmpl=component&listid=".$listid);
 			$buttonMap = XiusFactory::getModalButtonObject('savelist','@',$url,XIUSLIST_IFRAME_WIDTH,XIUSLIST_IFRAME_HEIGHT);
  			
         	$obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'" onClick="return xiusCheckUserSelected()">'
         					."<img src='". JURI::base()."components/com_xius/assets/images/save.png' title='".JText::_("Save This List")."' /></a>";
 			$toolbar['savelist'] = $obj;		
 		}
 		
 		if( XiusHelpersUtils::isAdmin($user->id) == true){
  			$obj 		= new stdClass();
  			$csvurl = JRoute::_("index.php?option=com_xius&view=users&task=export&format=csv");
  			$obj->value	= "<img src='".JURI::base()."components/com_xius/assets/images/excel.png' onClick=\"location.href='".JRoute::_($csvurl,false)."'\" title='Export TO CSV' />";
  			$toolbar['csv'] = $obj;
  		}
 		
  		return $toolbar;
  	}	
  }
