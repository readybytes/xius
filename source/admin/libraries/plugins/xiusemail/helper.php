<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusemailHelper
{
    function getUserDataFromCache($userid=0, $what='all')
    {
    	if(strtolower($what) === 'all')
    		$what = '*';
    		
    	$where = '';
    	if(!is_array($userid))
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
    	$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
    	$join = XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');
    	$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($conditions,$join,'userid','ASC',false);
		$userid= array();
		foreach($users as $u)
			$userid[] = $u->userid;
		
		return $userid;
    }
    
	function showErrorMessage($message,$recipient)
    {
    	$document = JFactory::getDocument();
    	if($recipient != array()){    		    	
        	$css= JURI::base().'administrator/components/com_xius/assets/css/front/xiusemail.css';
        	$document->addStyleSheet($css);        
    	
    		echo '<div class="xius_email" ><div class="xiusEmailHeader"><span>'.$message.'</span></div></div>';
    		echo '<ul>';
    		foreach($recipient as $rec)
    			echo "<li>$rec</li>";
    		
    		echo '<ul>';
    	}
    	
		$js = "window.setTimeout(\"parent.SqueezeBox.close()\", 5000);";
 		$document->addScriptDeclaration($js);
    }
	
}
