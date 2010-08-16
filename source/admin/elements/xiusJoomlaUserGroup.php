<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementXiusJoomlaUserGroup extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	// XITODO : change name of this element, add XIUS
	var	$_name = 'XiusJoomlaUserGroup';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$value = unserialize($value);
		if(!$value)
			$value[]='All';
		//if($value)
		$reqnone = false;		
		$infoHtml = $this->getInfoHTML($name,$value,$control_name,$reqnone);

		return $infoHtml;
	}
	
	
	function getInfoHTML($name,$value,$control_name='params',$reqnone=false)
	{		
		$group 	= $this->getJoomlaGroups();
		$html 	= $this->getOptionHtml($group, $name, $value,$control_name, 'multiple="multiple" size="9"' );
		return $html;
	}
	
	function getJoomlaGroups()
	{
		$db= & JFactory::getDBO();
		$sql = ' SELECT * FROM '.$db->nameQuote('#__core_acl_aro_groups') 
				.' WHERE '.$db->nameQuote('name').' NOT LIKE "%USERS%"' 
				.' AND '.$db->nameQuote('name').' NOT LIKE  "%ROOT%"'
				.' AND '.$db->nameQuote('name').' NOT LIKE  "%Public%"' ;
		$db->setQuery($sql);
		return $db->loadObjectList(); 		
	}
	
	function getOptionHtml($option, $name, $value,$control_name, $attribs = null)
	{
		if (is_array($attribs)) {
			$attribs = JArrayHelper::toString($attribs);
		}

        $html	= '<select name="'. $control_name.'['.$name.'][] '. $attribs .'>';
        $selected	= ( in_array('All',$value)) ? ' selected="true"' : '';
		$html .= '<option value="All" '.$selected.'>All</option>' ;
		
		foreach($option as $op){
			$selected	= ( in_array($op->value,$value)) ? ' selected="true"' : '';
			$html .= '<option value="'.$op->value.'" '.$selected.'>'.$op->value.'</option>' ;
			}
		
		$selected	= ( in_array('Guest Only',$value)) ? ' selected="true"' : '';
		$html .= '<option value="Guest Only" '.$selected.'>Guest Only</option>' ;
		$html	.= '</select>';

		return $html;
	}
}
