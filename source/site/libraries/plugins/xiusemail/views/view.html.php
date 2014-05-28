<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'joomla'.DS.'joomlahelper.php';

class XiusemailView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		return false;
	}
	
	function emailUser( $pluginId=null, $userId=null, $userSelected=null )
	{
		if($pluginId === null)
    		$pluginId = JRequest::getVar('pluginid',0,'GET');
    	
    	if($userId === null)
    		$userId = JRequest::getVar('userid',0,'GET');

    	if($userId=='selected' && $userSelected==null)
    			$userSelected = JRequest::getVar('selected','no','GET');
    			
		// load assets files
    	$this->loadAssets('js'	,'xiusemail.js');
    	$this->loadAssets('css'	,'xiusemail.css');
    			
        $data=array();
        $data['pluginId']		= $pluginId;
        $data['userId']			= $userId;
        $data['userSelected']	= $userSelected;
        $data['editor'] 		= JFactory::getEditor();
         
        $this->assignRef('data', $data);
        
        ob_start();
        $this->display('email');       
        
        $js="function xiusCheckEmailMessageExist(){
		       		var content = ".$data['editor']->getContent('xiusEmailMessageEl').";
		       		return content;     			
        		}
        	";
        $document = JFactory::getDocument();
		$document->addScriptDeclaration($js);
		$contents = ob_get_contents();
 		ob_end_clean();
        return $contents;
	}
	
	function getIndividualEmailLink($pluginId, $userId)
	{
		$linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$pluginId}&userid={$userId}&tmpl=component";
		$buttonMap = XiusFactory::getModalButtonObject('xius_email_button',XiusText::_('EMAIL'),$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
		
		$this->assign('pluginId',$pluginId);
		$this->assign('userId',$userId);
		$this->assign('buttonMap',$buttonMap );
		
		ob_start();
		$this->display('individualemail'); 
		$contents = ob_get_contents();
 		ob_end_clean();
        return $contents;        
	}
	
	function _setAdminToolbar($id , $task = 'emailUser', $option = null)
	{
		$this->loadAssets('js', 'xiusemail.js');
		// button for email to selected
        $linkMap 		= "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$id}&userid=selected&tmpl=component";
		$buttonMapSel 	= XiusFactory::getModalButtonObject('xius_emailselected_button','@',$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
		$this->assign('buttonMapSel',$buttonMapSel);
		$html  			= $this->loadTemplate('xiusemail_selected'); 			  			
  		XiusHelperToolbar::addToAdminToolbar('selected',$html);
        		
		// to send mail to all users
		$linkMap 		= "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$id}&userid=all&tmpl=component";
        $buttonMapAll 	= XiusFactory::getModalButtonObject('xius_emailall_button','@',$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
        $this->assign('buttonMapAll',$buttonMapAll);
        $html  			= $this->loadTemplate('xiusemail_all'); 			  			
  		XiusHelperToolbar::addToAdminToolbar('all',$html);        	
	}
}
