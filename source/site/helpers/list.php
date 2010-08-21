<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperList 
{
	function allowUserToAccessList($user,$allowedGroup,$allowGuest=false)
	{
		// if guest user are not allowed to access list ( create)
		// then check allowGuest is false and usertype is also false
		if($allowGuest === false && !$user->usertype)
			return false; 

		// if user is not registered then he will  be treated as guest
		if(!$user->usertype)
			$user->usertype = 'Guest Only';
			
		if(in_array('All', $allowedGroup)
				||	in_array($user->usertype, $allowedGroup) 
				||  XiusHelpersUtils::isAdmin($user->id) )
			return true;
		
		return false;
	} 
	
	function filterListAccordingToPrivacy($lists,$user)
	{
		if(!$user->usertype)
			$user->usertype = 'Guest Only';
			
		$count 	= count($lists);
		for( $i=0 ; $i < $count ; $i++ ){
			//  owner of list will not blocked to viewlist
			if($user->id == $lists[$i]->owner)
				continue;

			$config = new JParameter('','');
			$config->bind($lists[$i]->params);
			$joomlaPrivacy 	= $config->get('xiusListViewGroup','BLANK');
			
			//if joomla privacy param is blank then no need to unset, allowed to all
			if($joomlaPrivacy === 'BLANK' || !$joomlaPrivacy)
				continue;

			$joomlaPrivacy = unserialize($joomlaPrivacy);

			// check user is allowed to access list or not
			if(XiusHelperList::allowUserToAccessList($user,$joomlaPrivacy,true))
				continue;
				
			unset($lists[$i]);				
		}
		
		$lists = array_values($lists);
		return true;
	}
}