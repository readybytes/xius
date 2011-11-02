<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
//defined('_JEXEC') or die('Restricted access');

class Joomlahelper
{

	function getJoomlaFields($filter = '')
	{
		$db	= JFactory::getDBO();
			
		$userTable = new XiusTable('#__users','id', $db);
		$allColumns = $userTable->get('_db')->getTableFields('#__users');
		
		if(empty($allColumns) || empty($allColumns['#__users']) ){
			return false;
		}
			
		if(!empty($filter)){
			return $filter;
		}
			
		return $allColumns['#__users'];
	}	

    //get all usergroups
    static function getUserGroupHtml( $name,$value,$plginstance = null)
    {
    	$groups = XiusHelperUsers::getJoomlaGroups();

        // $plginstance-for identifying whether its element's html or not
    	if(!isset($plginstance)){
    		$all 		= new stdClass();
    	    $all->id 	= 'All';
    	    $all->{XIUS_JOOMLA_GROUP_VALUE} = "All";
    	    array_unshift($groups,$all);
    	}
    	
    	//if front-end then add 'select below' option
   		$attribs	= null;
    	if(!JFactory::getApplication()->isAdmin()){
			$start 		= new stdClass();
    		$start->id 	= 0;
    		$start->{XIUS_JOOMLA_GROUP_VALUE} = XiusText::_('SELECT_USERTYPE');
    		array_unshift($groups,$start);
    		
    	}
        //if back end then set attribute for multiselect list
    	else{
			$attribs = 'multiple="multiple" size="'.count($groups).'"';
		}
    	
		if (is_array($attribs)){
	    	$attribs = JArrayHelper::toString($attribs);
		}
 
      return JHTML::_('select.genericlist',$groups,$name,$attribs,'id',XIUS_JOOMLA_GROUP_VALUE,$value);
    }
}
