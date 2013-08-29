<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class JElementXiusTemplates extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	// XITODO : change name of this element, add XIUS
	var	$_name = 'XiusTemplates';

	function fetchElement($name, $value, &$node, $control_name)
	{		
		$infoHtml = $this->getTemplatesHTML($name,$value,$control_name);
		return $infoHtml;
	}
	
	
	function getTemplatesHTML($name,$value,$control_name='params')
	{		
		$html	= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" title="' . XiusText::_("SELECT_TEMPLATES") . '::' . XiusText::_("PLEASE_SELECT_A_TEMPLATE") . '">';
		foreach(JFolder::folders(XIUS_PATH_TEMPLATE) as $folder ){
		    $selected	= ( JString::trim($folder) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $folder . '"' . $selected . '>' . $folder . '</option>';
		}
		$html 	.= '</select>';		
		return $html;
	}
}
