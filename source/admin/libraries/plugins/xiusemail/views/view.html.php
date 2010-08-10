<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';

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
    			
		// add js file
        $js = JURI::base().'administrator/components/com_xius/assets/js/xiusemail.js';
        $css= JURI::base().'administrator/components/com_xius/assets/css/front/xiusemail.css';
        $document =& JFactory::getDocument();
        $document->addScript($js);
        $document->addStyleSheet($css);
        
        $data=array();
        $data['pluginId']		= $pluginId;
        $data['userId']			= $userId;
        $data['userSelected']	= $userSelected;
        $data['editor'] 		=& JFactory::getEditor();
         
        $this->assignRef('data', $data);
        
        ob_start();
        parent::display();       
        
        $js="function xiusCheckEmailMessageExist(){
		       		var content = ".$data['editor']->getContent('xiusEmailMessageEl').";
		       		return content;     			
        		}
        	";
		$document->addScriptDeclaration($js);
		$contents = ob_get_contents();
 		ob_end_flush();
        return $contents;
	}
}
