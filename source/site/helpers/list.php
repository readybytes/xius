<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperList 
{
	public static function isAccessibleToUser($user,$allowedGroup,$allowGuest=false)
	{
		// if guest user are not allowed to access list ( create)
		// then check allowGuest is false and usertype is also false

		$condition = empty($user->groups);

		if($allowGuest === false && $condition )
			return false; 

		// if user is not registered then he will  be treated as guest
//		$usertype = 'Guest Only';
//		if($user->usertype) 
//			$usertype = $user->usertype;

		if( in_array('All', $allowedGroup) ||
			XiusHelperUtils::isAdmin($user->id) )
			  return true;

		//if not J1.5 then check for each groupid assigned to that user	
	    if(!XIUS_JOOMLA_15){
			foreach ($user->groups as $group=>$gid){
				if(in_array($gid, $allowedGroup) )
					return true;
			}
	    }
        //if J1.5 then check for user's gid in allowedgroups
	    else{
				if(in_array($user->gid, $allowedGroup))
				    return true;
	    }
		return false;
	} 
	
	public static function filterListPrivacy(&$lists,$user)
	{			
		$count 	= count($lists);
		for( $i=0 ; $i < $count ; $i++ ){
			//  owner of list will not blocked to viewlist
			if($user->id == $lists[$i]->owner)
				continue;

			$config = new XiusParameter('','');
			$config->bind($lists[$i]->params);
			$joomlaPrivacy 	= $config->get('xiusListViewGroup','BLANK');
			
			//if joomla privacy param is blank then no need to unset, allowed to all
			if($joomlaPrivacy === 'BLANK' || !$joomlaPrivacy)
				continue;

			$joomlaPrivacy = unserialize($joomlaPrivacy);

			// check user is allowed to access list or not
			if(XiusHelperList::isAccessibleToUser($user,$joomlaPrivacy,true))
				continue;
				
			unset($lists[$i]);				
		}
		
		$lists = array_values($lists);
		return true;
	}
	
	public static function formatConditions($conditions)
	{
		if(!$conditions || !is_array($conditions))
			return false;
			
		$conditionHtml = array();
		foreach($conditions as $c){
			$instance = XiusFactory::getPluginInstance('',$c['infoid']);
			if(!$instance)
				continue;

			$value = $instance->_getFormatAppliedData($c['value']);
			if(!$value)
				continue;
			if(is_array($value))	
				$value = implode(',',$value);
				
			$conditionHtml[$c['infoid']]['label'] 	= $instance->getData('labelName');
			$conditionHtml[$c['infoid']]['operator']= $c['operator']; 
			$conditionHtml[$c['infoid']]['value'] 	= $value;
		}
		
		return $conditionHtml;
	}
}