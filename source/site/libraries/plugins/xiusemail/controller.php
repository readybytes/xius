<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

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
    	// XITODO : if not logged in then what to do
    	    	
    	if($pluginId === null)
    		$pluginId	= JRequest::getVar('pluginid',0,'GET');
    	
    	if($userId === null)
    		$userId = array(JRequest::getVar('userid',0,'GET'));
    	
    	if($post === null)
    		$post   = JRequest::get('POST');

   		// get the user id of users to email according to selected or all 
    	if($userId === array('selected'))
    	 	$userId = explode(',',$post['xiusSelectedUserid']);    	 	
    	else if($userId === array('all')){
    			$userId = XiusemailHelper::getResultedUserId();    		
    	}
    	
    	$instance 		= XiusFactory::getPluginInstance('',$pluginId);
    	if(!$instance)
    		return false;
    	
    	$params = $instance->getData('pluginParams');
    	$emailInfo  = $params->get('xius_email',0);
    	$emailIns	= XiusFactory::getPluginInstance('',$emailInfo);
    	if(!$emailIns)
    		return false;
    	
    	// get data from attached plugin information 
    	$tableMaping = $emailIns->getTableMapping();
    	$columnName =$tableMaping[0]->cacheColumnName;
    	$user = XiusemailHelper::getUserDataFromCache($userId, $columnName);
    	
    	// email configuration
    	$senderEmail  	= $loggedInUser->email;
    	$recipient = array();
    	foreach($user as $u)
    		$recipient[] = $u->$columnName;

    	$message = JRequest::getVar( 'xiusEmailMessageEl', '', 'post', 'string', JREQUEST_ALLOWRAW );
    	$sent=JUtility::sendMail($senderEmail, $loggedInUser->name,$senderEmail, $post['xiusEmailSubjectEl'], $message,1,null,$recipient );
    	if(is_object($sent)){
    		XiusemailHelper::showResultMessage('',array());
    		return false;
    	}
    	
    	$userName =  XiusemailHelper::getUserDataFromUsersTable($userId,'name');
    	$users = array();
    	foreach($userName as $u)
    		$users[] = $u->name;
    	XiusemailHelper::showResultMessage(XiusText::_("EMAIL SENT TO FOLLOWING USERS"),$users);
    	return true;    			
    }
}