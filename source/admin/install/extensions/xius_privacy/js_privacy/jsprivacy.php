<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Plugin
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class JElementJsprivacy extends JElement
{
	/**
	 * Element name
	 *
	 */
	var	$_name = 'JS Privacy';

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
		$htmlOption['public'] 	= XiusText::_("XIUS_LIST_PRIVACY_PUBLIC");
		$htmlOption['member'] 	= XiusText::_("XIUS_LIST_PRIVACY_MEMBER");
		$htmlOption['friend'] 	= XiusText::_("XIUS_LIST_PRIVACY_FRIEND");
		$htmlOption['self'] 	= XiusText::_("XIUS_LIST_PRIVACY_SELF");
		
		$html= '';
		$selectedOption			= $value;
			
		foreach($htmlOption as $key => $values){
			$select = '';
			if($selectedOption === $key)
				$select = " checked ";

			$html .= '<p><input type="radio" name="'.$name.'" value="'.$key.'" '.$select.'/>'.$values.'</p>';
 		}
 		return $html;
	}
}
