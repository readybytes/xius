<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperProfile
{
	public static function getUserProfileData($users)
	{
		//check configuration and call appropriate function
		$userData = array();
		self::jomSocialProfileData($users, $userData);
		
		$args 	= array();
		$args[] = & $userData; 
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayProfileLink',array( $args ));
		return $userData;
	}

	public static function jomSocialProfileData($users, &$userData)
	{
		$userId = JFactory::getUser()->id;
		$friendsIds = CFactory::getModel('friends')->getFriendIds($userId);
		//XITODO:: Some info nt required when cache speedup
		foreach($users as $user){

			$cuser 	= CFactory::getUser($user->userid);
			$data	= new stdClass();
			$data->id 		 	= $user->userid;
			$data->name 		= $cuser->getDisplayName();
			$data->thumbAvatar  = $cuser->getThumbAvatar();
			$data->status 	    = $cuser->getStatus();
			$data->profileLink  = XiusRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);
			$data->isOnline     = $cuser->isOnline();
		    $data->friendReq 	= "";
		    
		    $cfriend = new CFriends();

			if(!in_array($user->userid, $friendsIds) && $user->userid!=$userId)
			{
		        $data->friendReq = 'onclick="'. $cfriend->getPopup($user->userid).'" href="javascript:void(0);"';
			}

			$userData[] = $data;
		}
		
	}

}
