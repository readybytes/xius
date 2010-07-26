<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementInfo extends JElement
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
		if(isset($node->_attributes->addnone))
			$reqnone = true;
			
		$infoHtml = $this->getInfoHTML($name,$value,$control_name,$reqnone);

		return $infoHtml;
	}
	
	
	function getInfoHTML($name,$value,$control_name='params',$reqnone=false)
	{
		$html				= '';
		$allInfo = XiusLibrariesInfo::getAllInfo();
		
		$html	.= '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']" title="' . "Select Information" . '::' . "Please Select respective information" . '">';
			
		if($reqnone) {
			$selected	= ( JString::trim(-1) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="" ' . $selected . '>' . JText::_('SELECT BELOW') . '</option>';
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
}