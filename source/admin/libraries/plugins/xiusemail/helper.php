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
    	$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($conditions,'AND','userid','ASC',false);
		$userid= array();
		foreach($users as $u)
			$userid[] = $u->userid;
		
		return $userid;
    }
	
}
