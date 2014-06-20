<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class xiusJoomlahelper
{

	public static function getJoomlaFields($filter = '')
	{
		$db	= JFactory::getDBO();
			
		$userTable = new XiusTable('#__users','id', $db);
		$allColumns = $userTable->get('_db')->getTableColumns('#__users');
		
		if(empty($allColumns)){
			return false;
		}
			
		if(!empty($filter)){
			return $filter;
		}
			
		return $allColumns;
	}	

    //get all usergroups
	public static function getUserGroupHtml( $name, $value, $plginstance = null, $multiple = true)
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
    	if(!JFactory::getApplication()->isAdmin() || !$multiple){
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
