<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusemailHelper
{
    public static function getUserDataFromCache(Array $userid=array(), $what='all')
    {
    	if(strtolower($what) === 'all')
    		$what = '*';
    		
    	$where = '';
    	if(!is_array($userid) || count($userid)<1)
    		return false;
    	
    	$db =  JFactory::getDBO();	
    	$where = $db->quoteName('userid').' IN ('.implode(',',$userid).')' ;
    		
    	$query = " SELECT {$what} FROM `#__xius_cache` "
    			." WHERE {$where} "; 
    			
    	$db->setQuery( $query );
		return $db->loadObjectList();
    }
    
    public static function getResultedUserId()
    {
    	$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
    	$join  = XiusLibUsersearch::getDataFromSession(XIUS_JOIN,'AND');
    	$model = XiusFactory::getInstance ('users', 'model');
		$users = $model->getUsers($conditions,$join,'userid','ASC',false);
		$userid= array();
		foreach($users as $u)
			$userid[] = $u->userid;
		
		return $userid;
    }
    
	public static function showResultMessage($message,$recipient)
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
    
    public static function getUserDataFromUsersTable(Array $userid=array(),$what='all')
    {
    	if(strtolower($what) === 'all')
    		$what = '*';
    		
    	$where = '';
    	if(!is_array($userid) || count($userid)<1)
    		return false;
    	
    	$db = JFactory::getDBO();	
    	$where = $db->quoteName('id').' IN ('.implode(',',$userid).')' ;
    		
    	$query = " SELECT {$what} FROM `#__users` "
    			." WHERE {$where} "; 
    			
    	$db->setQuery( $query );
		return $db->loadObjectList();
    }
    
	
}
