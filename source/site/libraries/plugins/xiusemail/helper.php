<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusemailHelper
{
    function getUserDataFromCache(Array $userid=array(), $what='all')
    {
    	if(strtolower($what) === 'all')
    		$what = '*';
    		
    	$where = '';
    	if(!is_array($userid) || count($userid)<1)
    		return false;
    	
    	$db = & JFactory::getDBO();	
    	$where = $db->nameQuote('userid').' IN ('.implode(',',$userid).')' ;
    		
    	$query = " SELECT {$what} FROM `#__xius_cache` "
    			." WHERE {$where} "; 
    			
    	$db->setQuery( $query );
		return $db->loadObjectList();
    }
    
    function getResultedUserId()
    {
    	$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
    	$join = XiusLibUsersearch::getDataFromSession(XIUS_JOIN,'AND');
    	$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($conditions,$join,'userid','ASC',false);
		$userid= array();
		foreach($users as $u)
			$userid[] = $u->userid;
		
		return $userid;
    }
    
	function showResultMessage($message,$recipient)
    {
    	$document = JFactory::getDocument();
    	if($recipient != array()){    		    	
        	$css= JURI::base().'administrator/components/com_xius/assets/css/front/xiusemail.css';
        	$document->addStyleSheet($css);        
    	
    		echo '<div class="xius_email" ><div class="xiusEmailHeader"><span id="'.$message.'">'.$message.'</span></div></div>';
    		echo '<ul>';
    		foreach($recipient as $rec)
    			echo "<li id='".$rec."'>".JString::ucfirst($rec)."</li>";
    		
    		echo '</ul>';
    	}
    	
		$js = "window.setTimeout(\"parent.SqueezeBox.close()\", 30000);";
 		$document->addScriptDeclaration($js);
    }
    
    function getUserDataFromUsersTable(Array $userid=array(),$what='all')
    {
    	if(strtolower($what) === 'all')
    		$what = '*';
    		
    	$where = '';
    	if(!is_array($userid) || count($userid)<1)
    		return false;
    	
    	$db = & JFactory::getDBO();	
    	$where = $db->nameQuote('id').' IN ('.implode(',',$userid).')' ;
    		
    	$query = " SELECT {$what} FROM `#__users` "
    			." WHERE {$where} "; 
    			
    	$db->setQuery( $query );
		return $db->loadObjectList();
    }
    
	
}
