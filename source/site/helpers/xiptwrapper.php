<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
  return;

require_once JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'api.xipt.php';

class XiusHelperXiptwrapper
{
	/*
	 * Get Profile Type Name
	 * @profileTypeId, Profile Id
	 */
	public static function getProfileTypeName($profileTypeId)
	{
	    if(method_exists('XiptAPI','getProfileTypeName'))
			return XiptAPI::getProfileTypeName($profileTypeId);
		
		return XiPTLibraryProfiletypes::getProfiletypeName($profileTypeId);
	}
	
	/*
	 * return array of all published Profile Type id
	 * @filter, use for filter Profile Type 
	 */
	public static function getProfileTypeIds($filter= '')
	{
		if(method_exists('XiptAPI', 'getProfileTypeIds'))
				return XiptAPI::getProfileTypeIds($filter);
		
		return XiPTLibraryProfiletypes::getProfiletypeArray($filter);
	}
	
	/*
	 * return JomSocial Profile Fields
	 */
	public static function getJSProfileFields($fieldId=0)
	{
		if(method_exists('XiptAPI','getJSProfileFields'))
				return XiptAPI::getJSProfileFields($fieldId);
		
		return XiPTHelperProfileFields::get_jomsocial_profile_fields($fieldId);
	}
	
	/*
	 * filter Profile-Type fields according to Profile Type
	 */

	public static function filterProfileTypeFields(&$fields, $selectedProfiletypeID, $from)
	{
		if(method_exists('XiptAPI','filterProfileTypeFields'))
				return XiptAPI::filterProfileTypeFields($fields, $selectedProfiletypeID, $from);

		return XiPTLibraryProfiletypes::_getFieldsForProfiletype($fields, $selectedProfiletypeID, $from);
	}	
	
	/**
	 * returns user information
	 * @param $userid : 
	 * @param $what : can be 'PROFILETYPE' or 'TEMPLATE'
	 * @return user information
	 */
	public static function getUserInfo($userid, $what='PROFILETYPE')
	{
		if(method_exists('XiptAPI' ,'getUserInfo'))
				return XiptAPI::getUserInfo($userid,$what);

		return XiPTLibraryProfiletypes::getUserData($userid,$what);	
	}	
}