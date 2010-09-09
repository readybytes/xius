<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperToolbar 
{
	function getAdminToolbar($listid, $task, $submitUrl)
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
 		
		/*
		 *  get the xiurl from , so that proper vars can be set in url
		 *  if from internal url then reset view and task
		 *  otherwise ad prefix xius 
		 */
		$uri = new JURI($submitUrl['xiurl']);
		$prefix = '';
		if($submitUrl['isExternal'] === true)
			$prefix = 'xius'; 
		
		
		/*
		 * get toolbar option for save list
		 */
		if(XiusHelperList::isAccessibleToUser($user,$listCreator)){
  			$obj 		= new stdClass();
  			$uri->setVar($prefix.'view','list');
  			$uri->setVar($prefix.'task','saveas');
  			$uri->setVar('tmpl','component');
  			$uri->setVar('listid',$listid);
  			$url 		= XiusRoute::_($uri->toString());
 			$buttonMap = XiusFactory::getModalButtonObject('savelist','@',$url,XIUSLIST_IFRAME_WIDTH,XIUSLIST_IFRAME_HEIGHT);
  			
         	$obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'" onClick="return xiusCheckUserSelected()">'
         					."<img src='". JURI::base()."components/com_xius/assets/images/save.png' title='".XiusText::_("Save This List")."' /></a>";
 			$toolbar['savelist'] = $obj;		
 		}
 		
 		/*
 		 * get toolbar option for exporting the list in csv format
 		 */
 		if( XiusHelpersUtils::isAdmin($user->id) == true){
  			$obj 		= new stdClass();
  			$uri->setVar($prefix.'view','users');
  			$uri->setVar($prefix.'task','export');  			
  			$uri->setVar('format','csv');
  			$csvurl		= XiusRoute::_($uri->toString());  			 
  			$obj->value	= "<img src='".JURI::base()."components/com_xius/assets/images/excel.png' onClick=\"location.href='".XiusRoute::_($csvurl,false)."'\" title='Export TO CSV' />";
  			$toolbar['csv'] = $obj;
  		}
 		
  		return $toolbar;
  	}	
  }
