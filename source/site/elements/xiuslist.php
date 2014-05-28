<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class JElementXiuslist extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Xiuslist';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$reqnone = false;
		$reqall = false;
		if(isset($node->_attributes->addnone) || isset($node->_attributes['addnone']))
			$reqnone = true;
			
		if(isset($node->_attributes->addall) || isset($node->_attributes['addall']))
			$reqall = true;
			
		$ptypeHtml = $this->getXiuslistFieldHTML($name,$value,$control_name,$reqnone,$reqall);

		return $ptypeHtml;
	}
	
	
	function getXiuslistFieldHTML($name,$value,$control_name='params',$reqnone=false,$reqall=false)
	{	
		require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
		$html				= '';
		$options			= XiusLibList::getLists('','AND',false);
		
		$html	.= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" title="' . "Select Account Type" . '::' . "Please Select your account type" . '">';
		
		if($reqall) {
			$selected	= ( JString::trim(0) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . 0 . '"' . $selected . '>' . XiusText::_("ALL") . '</option>';
		}
		
		if($reqnone) {
			$selected	= ( JString::trim(-1) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . -1 . '"' . $selected . '>' . XiusText::_("NONE") . '</option>';
		}
		
		for( $i = 0; $i < count( $options ); $i++ )
		{
		    $option		= $options[ $i ]->name;
			$id			= $options[ $i ]->id;
		    
		    $selected	= ( JString::trim($id) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $id . '"' . $selected . '>' . $option . '</option>';
		}
			
		$html	.= '</select>';		
		return $html;
	}
}