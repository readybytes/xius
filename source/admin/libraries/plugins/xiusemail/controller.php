<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusPluginControllerXiusemail extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function display() 
	{
		parent::display();
    }
    
    function emailUser($pluginId=null, $userId=null)
    {
   		if($pluginId === null)
    		$pluginId = JRequest::getVar('pluginid',0,'GET');
    	
    	if($userId === null)
    		$userId = JRequest::getVar('userid',0,'GET');
    	        
    	// add js file
        $js = JURI::base().'administrator/components/com_xius/assets/js/xiusemail.js';
        $css= JURI::base().'administrator/components/com_xius/assets/css/front/xiusemail.css';
        $document =& JFactory::getDocument();
        $document->addScript($js);
        $document->addStyleSheet($css);
        
    	// display the form for emailing
      	echo '<div class="xius_email" >'
			.'<form action="index.php?option=com_xius&task=sendEmail&plugin=xiusemail&pluginid='.$pluginId.'&userid='.$userId.'&tmpl=component" method="POST" id="xiusEmail" onSubmit="javascript:listSelectUser();"><h3>'
			.'<div class="xiusEmailHeader"><span>'.JText::_('XIUS EMAIL').'</span></div>'
			.'<div class="xiusEmailBox">'
			.'<div class="xiusEmailEntity">'
			.'<div class="xiusEmailLabel">'
			.'<span>'.JText::_('XIUS EMAIL SUBJECT').'</span>'
			.'</div>'
			.'<div class="xiusEmailControl">'
			.'<input type="text" name="xiusEmailSubjectEl" id="xiusAddressEl" value="" class="input_box" size="40" /><br/><br/>'
			.'</div></div>'
			.'<div class="xiusEmailEntity">'
			.'<div class="xiusEmailLabel">'
			.'<span>'.JText::_('XIUS EMAIL MESSAGE').'</span>'
			.'</div>'
			.'<div class="xiusEmailControl">'
			.'<textarea name="xiusEmailMessageEl" id="xiusAddressEl" value="" class="input_box" rows="20" cols="45"></textarea><br/>'
			.'</div></div>'
			.'</div>'
			.'<input type="hidden" name="xius_selected_userid" id="xius_selected_userid" value="" />'
			.'<div class="xiusEmailFooter">'
			.'<input type="submit" name="send" value="'. JText::_('XIUS EMAIL SEND').'" />'
			.'<input type="button" name="cancel" value="'. JText::_('XIUS EMAIL CANCEL').'" />'
			.'</div>'
			.'</h3></form>'
			.'</div>';

    }
    
    function sendEmail($pluginId=null, $userId=null, $post=null)
    {
    	require_once(dirname(__FILE__).DS.'helper.php');
    	$loggedInUser 	= JFactory::getUser();
    	// XITODO : if not logged in then what to do
    	    	
    	if($pluginId === null)
    		$pluginId	= JRequest::getVar('pluginid',0,'GET');
    	
    	if($userId === null)
    		$userId = array(JRequest::getVar('userid',0,'GET'));
    	
    	if($post === null)
    		$post   = JRequest::get('POST');
    		
    	if($userId === array('selected'))
    	 	$userId = explode(',',$post['xius_selected_userid']);    	 	
    	else if($userId === array('all'))
    		$userId = XiusemailHelper::getResultedUserId();
    		
    	$instance 		= XiusFactory::getPluginInstanceFromId($pluginId);
    	if(!$instance)
    		return false;
    	
    	$params = $instance->getData('pluginParams');
    	$emailInfo  = $params->get('xius_email',0);
    	$emailIns	= XiusFactory::getPluginInstanceFromId($emailInfo);
    	if(!$emailIns)
    		return false;
    		
    	$tableMaping = $emailIns->getTableMapping();
    	$columnName =$tableMaping[0]->cacheColumnName;
    	$user = XiusemailHelper::getUserDataFromCache($userId, $columnName);
    	
    	
    	$serderEmail  	= $loggedInUser->email;
    	$recipient = array();
    	foreach($user as $u)
    		$recipient[] = $u->$columnName;
    		
    	JUtility::sendMail($serderEmail, $loggedInUser->name, $recipient, $post['xiusEmailSubjectEl'], $post['xiusEmailMessageEl'] );
    }
}
