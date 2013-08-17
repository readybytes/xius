<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperProfile
{
	function getUserProfileData($users)
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

	function jomSocialProfileData($users, &$userData)
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
			$data->isOnline    = $cuser->isOnline();
		    $data->friendReq 	= "";

			if(!in_array($user->userid, $friendsIds) && $user->userid!=$userId)
			{
		        $data->friendReq = 'onclick="'. CFriends::getPopup($user->userid).'" href="javascript:void(0);"';
			}

			$userData[] = $data;
		}
		
	}

}
