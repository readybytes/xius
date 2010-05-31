<?php
/**
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

class ProfiletypesHelper
{
	/* Value must be numeric */
	var $_mainframe;
	var $_task;
	var $_view;
	var $_params;
	
	/* if data not available,
	 * then find user's profiletype and return
	 * else present defaultProfiletype to community
	 *
	 * So there will be always a valid value returned
	 * */
	function formatData($value=0)
	{
	    $pID = $value;
		return $pID;
	}
	/*
	 * Convert stored profileType ID to profileTypeName
	 *
	 * */
	function getFieldData( $value = 0 )
	{
		$pID = $value;
		
		if(!$pID)
			return '';
		
		$pName = XiPTLibraryProfiletypes::getProfiletypeName($pID);
		return $pName;
	}
	
	/*
	 * Generate input HTML for field
	 */
	function getFieldHTML($field)
	{
		$html	    = '';
		//$pID	    = $field->value;
		$class	    = '';
		$disabled   = '';
		
		
		$filter	= array('published'=>1);
		// user can change profiletype, add information
		$pTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
	
		if(!empty($pTypes)){
			foreach($pTypes as $pType){
				$html	.= '<option value="' . $pType->id . '" >' .$pType->name  . '</option>';
			}
		}
		
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
}
