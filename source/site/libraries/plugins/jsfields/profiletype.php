<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class ProfiletypesHelper
{
	function formatData($value=0)
	{
	  return $value;
	}
	/*
	 * Convert stored profileType ID to profileTypeName
	 *
	 * */
	function getFieldData( $value = 0 )
	{
		if(!$value)
			return '';
		
		return XiusHelperXiptwrapper::getProfileTypeName($value);
	}
	
	/*
	 * Generate input HTML for field
	 */
	function getFieldHTML($field)
	{
		$profileTypeInfoId = JRequest::getVar('profileType',0);
		$filter	= array('published'=>1,'visible'=>1);
		// user can change profiletype, add information
		$pTypes = XiusHelperXiptwrapper::getProfileTypeIds($filter);
		$startUp = new stdClass();
		$startUp->id = 0;
		$startUp->name = XiusText::_("SELECT_BELOW");
		array_unshift($pTypes,$startUp);
        return JHTML::_('select.genericlist',$pTypes,'field'.$field->id,"",'id', "name",$profileTypeInfoId);
  }
}
