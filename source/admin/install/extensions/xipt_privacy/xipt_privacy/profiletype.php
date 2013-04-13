<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementProfiletype extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Profiletypes';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$reqnone = false;
		$reqall  = false;
		$value	 = unserialize($value);
		if(isset($node->_attributes->addnone))
			$reqnone = true;
			
		if(isset($node->_attributes->addall))
			$reqall = true;
			
		$ptypeHtml = $this->getProfiletypeFieldHTML($name,$value,$control_name,$reqnone,$reqall);

		return $ptypeHtml;
	}
	
	
	function getProfiletypeFieldHTML($name,$value,$control_name='params',$reqnone=false,$reqall=false)
	{	
		$required			='1';
		$html				= '';
		$class				= ($required == 1) ? ' required' : '';
		$options			= XiusHelperXiptwrapper::getProfileTypeIds();
						
		$html		.= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.'][]" multiple="multiple" size="9">';
		$selected	 = ( in_array(0,$value)) ? ' selected="true"' : '';
		$html		.= '<option value="' . 0 . '"' . $selected . '>' . XiusText::_("ALL") . '</option>';
	
		foreach($options as $op){
			$selected	 = ( in_array($op->id,$value)) ? ' selected="true"' : '';
			$html 		.= '<option value="'.$op->id.'" '.$selected.'>'.$op->name.'</option>' ;
			}
			
		$selected	= ( in_array(-1,$value)) ? ' selected="true"' : '';
		$html	.= '<option value="' . -1 . '"' . $selected . '>' . XiusText::_("NONE") . '</option>';		
		$html	.= '</select>';	
		$html   .= '<span id="errprofiletypemsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
}