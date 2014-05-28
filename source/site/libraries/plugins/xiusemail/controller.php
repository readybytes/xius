<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusPluginControllerXiusemail extends JControllerLegacy
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function emailUser()
    {   		
    	require_once(dirname(__FILE__).DS.'views'.DS.'view.html.php');
		$view= new XiusemailView();			
	
		echo  $view->emailUser();
		return; 
    }
    
    function sendEmail($pluginId=null, $userId=null, $post=null)
    {
    	require_once(dirname(__FILE__).DS.'helper.php');
    	   	   	
    	$loggedInUser 	= JFactory::getUser();
    	// If user is not login then nither sent email nor msg
    	if(empty($loggedInUser->id)){
    		JFactory::getApplication()->enqueueMessage(XiusText::_("PLEASE_LOGIN_FIRST"));
    		return false;
    	}
    	
    	//Set All initial Values
    	if($pluginId === null){
    		$pluginId	= JRequest::getVar('pluginid',0,'GET');
    	}   	
    	if($userId === null){
    		$userId = array(JRequest::getVar('userid',0,'GET'));
    	}
    	if($post === null){
    		$post   = JRequest::get('POST');
    	}

        // get Xius-Email Plugin Instance
    	$plugInstance 	= XiusFactory::getPluginInstance('',$pluginId);
    	if(!$plugInstance){
    		return false;
    	}
    	
   		// fetch user_ids according to selected or all option 
    	if($userId === array('selected')){
    	 	$userId = explode(',',$post['xiusSelectedUserid']);
    	}    	 	
    	elseif($userId === array('all')){
    			$userId = XiusemailHelper::getResultedUserId();    		
    	}
    	
    	//get "message or email" for sending
    	$message 	= JRequest::getVar( 'xiusEmailMessageEl', '', 'post', 'string', JREQUEST_ALLOWRAW );
    	
    	// Send Message
    	if($this->_sendMessage($post, $userId, $message)){
    		return true;
    	}
    	// Send Mail
    	if($this->_sendEmail($loggedInUser, $plugInstance, $post, $userId, $message)){
    		return true; 
    	}
    	return false;   			
    }
    
    /**
     * Send Messages
     * @param $userId
     * @param $post
     * @param $message
     */
    function _sendMessage($post, $userId, $message)
    {
    	//When Click on Send-msg button then Set Send msg
    	if(!array_key_exists('sendmsg',$post)){
    		return false;
    	}
    	
    	
    	$info['to'] 	 = $userId;
    	$info['subject'] = $post['xiusEmailSubjectEl'];
    	$info['body']	 = strip_tags($message);
    	
    	$inboxModel = CFactory::getModel('inbox');
    	$inboxModel->send($info);
    		
    	XiusemailHelper::showResultMessage(XiusText::_("MESSAGE_SENT_TO_FOLLOWING_USERS"),$this->getUserName($userId));
    	return true;
    }
    
    function _sendEmail($loggedInUser, $plugInstance, $post, $userId, $message) 
    {
    	// Get Xius-Email Plugin Information. It must be "Email"(user-email)
    	$params 	= $plugInstance->getData('pluginParams');
    	$emailInfo  = $params->get('xius_email',0);
    	$emailIns	= XiusFactory::getPluginInstance('',$emailInfo);
    	
    	// If XiUS-Email Plugin Information not set Then return false
    	if(!$emailIns){
    		JFactory::getApplication()->enqueueMessage(XiusText::_("PLUGIN_PRAMETERR_NOT_SET"));
    		return false;
    	}
    	
    	// get data from Cache Table According to Plugin Information  
    	$tableMaping	= $emailIns->getTableMapping();
    	$columnName		= $tableMaping[0]->cacheColumnName;
    	$user 			= XiusemailHelper::getUserDataFromCache($userId, $columnName);
    	
    	// email configuration
    	$senderEmail  	= $loggedInUser->email;
    	$recipient = array();
    	foreach($user as $u){
    		$recipient[] = $u->$columnName;
    	}
    	
    	// sent email
    	$mailer  = JFactory::getMailer();
    	$sent	 = $mailer->sendMail($senderEmail, $loggedInUser->name,$senderEmail, $post['xiusEmailSubjectEl'], $message,1,null,$recipient );
    	
    	if(is_object($sent)){
    		XiusemailHelper::showResultMessage('',array());
    		return false;
    	}

    	XiusemailHelper::showResultMessage(XiusText::_("EMAIL_SENT_TO_FOLLOWING_USERS"),$this->getUserName($userId));
    	return true;  
    }
    
    /**
     * Show result 
     * @param $userId is array of userIds.
     */
    function getUserName($userId) {
    	
    	$userName =  XiusemailHelper::getUserDataFromUsersTable($userId,'name');
    	$users = array();
    	foreach($userName as $u){
    		$users[] = $u->name;
    	}
    	return $users;
    }
}