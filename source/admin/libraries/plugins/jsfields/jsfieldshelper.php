<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class Jsfieldshelper
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
		$result = $db->loadObjectList();
		
		$fields = array();
		
		for($i = 0; $i < count($result); $i++)
		{
			// Re-arrange options to be an array by splitting them into an array
			if(isset($result[$i]->options) && $result[$i]->options != '')
			{
				$options	= $result[$i]->options;
				$options	= explode("\n", $options);

				array_walk($options, array( 'JString' , 'trim' ) );
				
				$result[$i]->options	= $options;
				
			}

			$fields[$i] = $result[$i];
		}
	    	
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
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php' );
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		
		$fieldHTML = '';
		//isset($result[$i]['options']) && $result[$i]['options'] != '')
		/*if(isset($fieldInfo->options) && $fieldInfo->options != '')
			$options	= explode("\n", $options);*/
		
		/*IMP : if change date field data into y-mm-dd ,
		 * then take care of jsfields formatValue function also
		 */
		if($fieldInfo->type == 'date') {
			$fieldHTML ='<input class="inputbox" type="text" name="field'.$fieldInfo->id.'" id="field'.$fieldInfo->id.'" style="width:125px; margin-right:4px" value="" />';
			$fieldHTML .= '<a href="javascript:void(0)" onclick="return showCalendar(\'field'.$fieldInfo->id.'\', \'dd-mm-y\');" ><img src="'.rtrim(JURI::root()).'components/com_community/assets/calendar.png"></a>';
		}
		else
			$fieldHTML = CProfileLibrary::getFieldHTML($fieldInfo);
		
		
		return $fieldHTML;
	}
	
	
	
	function getFieldType($fieldId)
	{
		$filter = array();
		$filter['id'] = $fieldId;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo))
			return false;
			
		return $fieldInfo[0]->type;
	}
	
	
	
	function isJomsocialExist()
	{
		
	}
	
}