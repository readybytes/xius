<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class JElementTablecolumns extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Table columns';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$infoHtml = $this->getTableHTML($name,$value,$control_name);
		return $infoHtml;
	}
	
	
	function getTableHTML($name,$value,$control_name='params')
	{
		$pluginId  = JRequest::getVar('editId', 0);
		$tableName = null;
		
		if($pluginId){
			$pluinInstance = XiusFactory::getPluginInstance('',$pluginId);
			$tableName     = $pluinInstance->getData('key'); 
		}
		else
			$tableName = JRequest::getVar('rawdata', null);

		// raise error if table name is not found	
		assert(isset($tableName));
		
		$db     = JFactory::getDBO();
		$query = " SHOW COLUMNS FROM ".XiusTable::replacePrefix($tableName);
		$db->setQuery($query);
		$columns = $db->loadObjectList();	
		
		$html = '<select id="'.$control_name.'['.$name.']" name="'.$control_name.'['.$name.']">';
		
		foreach($columns as $c){		    
		    $selected	= ( JString::trim($c->Field) == $value ) ? ' selected="true"' : '';
			$html	.= '<option value="' . $c->Field . '"' . $selected . '>' . $c->Field . '</option>';
		}
			
		$html	.= '</select>';	
//		$html   .= '<span id="errinfomsg" style="display: none;">&nbsp;</span>';
		
		return $html;
	}
}