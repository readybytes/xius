<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
require_once (JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php');

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
		
		return XiPTLibraryProfiletypes::getProfiletypeName($value);
	}
	
	/*
	 * Generate input HTML for field
	 */
	function getFieldHTML($field)
	{
		$class	    = '';
		$disabled   = '';
		
		$profileTypeInfoId = JRequest::getVar('profileType',0);
		
		$filter	= array('published'=>1);
		// user can change profiletype, add information
		$pTypes = XiPTLibraryProfiletypes::getProfiletypeArray($filter);
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
	
		$html   .= '<option value="">'.XiusText::_('SELECT BELOW').'</option>';
		if(!empty($pTypes)){
			foreach($pTypes as $pType){
				$selected = '';			
				
				if(isset($field->value) && $field->value == $pType->id)
					$selected = " selected = selected ";

					$selected=($pType->id==$profileTypeInfoId) ? "selected" : '';
					
				$html	.= '<option value="' . $pType->id . '" '.$selected.'>' .$pType->name  . '</option>';
			}
		}
		
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
}
