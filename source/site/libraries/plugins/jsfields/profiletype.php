<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');


class ProfiletypesHelper
{
	public static function formatData($value=0)
	{
	  return $value;
	}
	/*
	 * Convert stored profileType ID to profileTypeName
	 *
	 * */
	public static function getFieldData( $value = 0 )
	{
		if(!$value)
			return '';
		
		return XiusHelperXiptwrapper::getProfileTypeName($value);
	}
	
	/*
	 * Generate input HTML for field
	 */
	public static function getFieldHTML($field)
	{
		$profileTypeInfoId = JRequest::getVar('profileType',0);
		$attr   = null;
		$filter	= array('published'=>1,'visible'=>1);
		// user can change profiletype, add information
		$pTypes = XiusHelperXiptwrapper::getProfileTypeIds($filter);
		
        //if admin then set attr for multiselect type and get default 
        //selected from value[param]
		if(JFactory::getApplication()->isAdmin()){
			$profileTypeInfoId = $field->value; //selected values stored in value[param]
			$attr 			   = 'multiple="multiple" size="'.count($pTypes).'"';
			$name              = 'profiletype[param][]';
		}
         //if site then add "select below" option
		else{
			$name 		   = 'field'.$field->id;
		 	$startUp 	   = new stdClass();
		 	$startUp->id   = 0;
			$startUp->name = XiusText::_("SELECT_BELOW");
			array_unshift($pTypes,$startUp);
		}
		
        return JHTML::_('select.genericlist',$pTypes,$name,$attr,'id', "name",$profileTypeInfoId);
  }
}
