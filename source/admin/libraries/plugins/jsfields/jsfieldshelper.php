<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class jsfieldshelper
{

	function getJomsocialFields($filter = '')
	{
		$db	=& JFactory::getDBO();
			
		//setting up the search condition is there is any
		$wheres = array();
		if(! empty($filter)){
			foreach($filter as $column => $value)
				$wheres[] = "`$column` = " . $db->Quote($value); 	
		}
			
		$sql = "SELECT * FROM " . $db->nameQuote('#__community_fields');
		
		if(! empty($wheres))
		   $sql .= " WHERE ".implode(' AND ', $wheres);
		
		$sql .= " ORDER BY `ordering`";
			
		$db->setQuery($sql);
		$fields = $db->loadObjectList();
	    	
		return $fields;
	}
	
	
	/*fieldInfo contain a field information ( like Gender id ,fieldcode etc.
	 * Function will return that field html
	 */
	function getFieldsHTML($fieldInfo)
	{
		$document	=& JFactory::getDocument();
		$document->addStyleSheet(JURI::root()."includes/js/calendar/calendar-mos.css");
		$document->addScript(JURI::root()."includes/js/joomla.javascript.js");
		$document->addScript(JURI::root()."includes/js/calendar/calendar_mini.js");
		$document->addScript(JURI::root()."includes/js/calendar/lang/calendar-en-GB.js");
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		
		$fieldHTML = array();
		
		if($fieldInfo->type == 'date') {
			$fieldHTML ='<input class="inputbox" type="text" name="field'.$fieldInfo->id.'" id="field'.$detail->id.'" style="width:125px; margin-right:4px" value="" />';
			$fieldHTML .= '<a href="javascript:void(0)" onclick="return showCalendar(\'field'.$detail->id.'\', \'y-mm-dd\');" ><img src="'.rtrim(JURI::root()).'components/com_community/assets/calendar.png"></a>';
		}
		else
			$fieldInfo = CProfileLibrary::getFieldHTML($fieldInfo);
		
		
		return $fieldHTML;
	}
	
	
	function isJomsocialExist()
	{
		
	}
	
}