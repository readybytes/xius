<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'xiptwrapper.php';

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
		
		return XiptWrapper::getProfileTypeName($value);
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
		$pTypes = XiptWrapper::getProfileTypeIds($filter);
		
		$html	= '<select id="field'.$field->id.'" name="field' . $field->id  . '" '.$disabled.' class="hasTip select'.$class.' inputbox" title="' . $field->name . '::' . htmlentities( $field->tips ). '">';
	
		$html   .= '<option value="">'.XiusText::_('SELECT BELOW').'</option>';
		if(!empty($pTypes)){
			foreach($pTypes as $pType){
				$selected = '';			
				
				if(isset($field->value) && $field->value == $pType->id)
					$selected = " selected = selected ";

					$selected = (isset($profileTypeInfoId) && $pType->id==$profileTypeInfoId) ? "selected" : $selected;
					
				$html	.= '<option value="' . $pType->id . '" '.$selected.'>' .$pType->name  . '</option>';
			}
		}
		
		$html	.= '</select>';
		$html   .= '<span id="errfield'.$field->id.'msg" style="display:none;">&nbsp;</span>';
		
		return $html;
	}
}
