<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteHelperProfile
{
	function getUserProfileData($users)
	{
		//check configuration and call appropriate function
		$userData = array();
		self::jomSocialProfileData($users, $userData);
		
		$args = array();
		$args[] = & $userData; 
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayProfileLink',array( $args ));
		return $userData;
	}

	function jomSocialProfileData($users, &$userData)
	{
		foreach($users as $user){

			$cuser = CFactory::getUser($user->userid);
			$data	= new stdClass();
			$data->id 		 	= $user->userid;
			$data->name 		= $cuser->getDisplayName();
			$data->thumbAvatar  = $cuser->getThumbAvatar();
			$data->status 	    = $cuser->getStatus();
			$data->profileLink  = XiusRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);

			$data->messageHref = 'onclick="'. CMessaging::getPopup($user->userid).'" href="javascript:void(0);"';
			$data->friendCount = $cuser->getFriendCount();
			$data->friendHref  = 'href="'.XiusRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id,false ).'"';
			$data->isOnline    = $cuser->isOnline();

			$userData[] = $data;
		}
		
	}

}
