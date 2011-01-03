<?php

// Check to ensure this file is included in Joomla!
if(!defined('_JEXEC')) die('Restricted access');

class JElementTablecolumns extends JElement
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
			$pluinInstance = XiusFactory::getPluginInstanceFromId($pluginId);
			$tableName     = $pluinInstance->getData('key'); 
		}
		else
			$tableName = JRequest::getVar('rawdata', null);

		// raise error if table name is not found	
		assert(isset($tableName));
		
		$db     = JFactory::getDBO();
		$query = " SHOW COLUMNS FROM ".$db->replacePrefix($tableName);
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