<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
class JElementInfo extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Info';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$reqnone = false;
		// PHP 5.3 Specific
		// we always give attribute addnone if and only if we need to show this
		// other wise we don't set this attribute
		if(isset($node->_attributes->addnone)|| isset($node->_attributes['addnone']))
			$reqnone = true;
			
		if($name == 'xiusSortInfo')
			$infoHtml = $this->getAllInfoHTML($name,$value,$control_name,$reqnone);
		else
			$infoHtml = $this->getInfoHTML($name,$value,$control_name,$reqnone);

		return $infoHtml;
	}
	
	
	function getInfoHTML($name,$value,$control_name='params',$reqnone=false)
	{
		$html				= '';
		$allInfo = XiusLibInfo::getAllInfo();
		
		$html	.= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" title="' . "Select Information" . '::' . "Please Select respective information" . '">';
			
		if($reqnone) {
			$selected	= ( JString::trim(-1) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="" ' . $selected . '>' . XiusText::_('SELECT_BELOW') . '</option>';
		}
		
		for( $i = 0; $i < count( $allInfo ); $i++ )
		{
			if($allInfo[ $i ]->pluginType=='Proximity')
				continue;
				
		    $option		= $allInfo[ $i ]->labelName;
			$id			= $allInfo[ $i ]->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
			
		$html	.= '</select>';	
		$html   .= '<span id="errinfomsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
	
	function getAllInfoHTML($name,$value,$control_name='xiusparams',$reqnone=false)
	{
		//$allInfo = XiusLibInfo::getAllInfo();
		$allInfo = XiusLibUsersearch::getSortableFields();
		$startUp = new stdClass();
		$startUp->key = 0;
		$startUp->value = "Select Below";
		array_unshift($allInfo,$startUp);
		$defaultSelect = XiusHelperUtils::getConfigurationParams('xiusSortInfo',0);
		return JHTML::_('select.genericlist',  $allInfo,$control_name."[".$name."]", "", 'key', 'value',$defaultSelect);
	}
}
