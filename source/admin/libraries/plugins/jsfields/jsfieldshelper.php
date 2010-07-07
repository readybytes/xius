<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class Jsfieldshelper
{

	function getJomsocialFields($filter = '',$reset = false)
	{
		$result = self::getAllJomsocialFields($reset);
		
		//B'coz we want those result which satisfy all conditions.
		//so unset result which broke even a single condition
		if(!empty($result) && !empty($filter)){
			foreach($filter as $fk => $fv){
				foreach($result as $rk => $rv){
					if($rv->$fk != $fv)
						unset($result[$rk]);
				}
			}
		}
		
		$result = array_values($result);
		
		$fields = array();
		
		for($i = 0; $i < count($result); $i++)
		{
			// Re-arrange options to be an array by splitting them into an array
			if(isset($result[$i]->options) 
					&& $result[$i]->options != '' 
						&& !is_array($result[$i]->options))
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
	
	
	/*function getJomsocialFields($filter = '')
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
	}*/
	
	
	
	function getAllJomsocialFields($reset = false)
	{
		static $jsFields;
		
		if(!$reset && isset($jsFields))
			return $jsFields;
			
		$db	=& JFactory::getDBO();
		$sql = "SELECT * FROM " . $db->nameQuote('#__community_fields');
		$sql .= " ORDER BY `ordering`";
		$db->setQuery($sql);
		$jsFields = $db->loadObjectList();
		
		return $jsFields;
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
		
		/*IMP : if change date field data into y-mm-dd ,
		 * then take care of jsfields formatValue function also
		 */
		if($fieldInfo->type == 'date') {
			$value = '';
			if(isset($fieldInfo->value))
				$value = $fieldInfo->value;
				
			$mySess 	= & JFactory::getSession();
			$formName	= $mySess->get('xiusModuleForm','','XIUS');
       		if($formName != '')
       			$formName .= "_{$formName}";
       			
			$fieldHTML ='<input class="inputbox" type="text" name="field'.$fieldInfo->id.'" id="field'.$fieldInfo->id.$formName.'" style="width:125px; margin-right:4px" value="'.$value.'" />';
			$fieldHTML .= '<a href="javascript:void(0)" onclick="return showCalendar(\'field'.$fieldInfo->id.$formName.'\', \'dd-mm-y\');" ><img src="'.rtrim(JURI::root()).'components/com_community/assets/calendar.png"></a>';
		}
		else if($fieldInfo->type == 'profiletypes'){
			require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::getFieldHTML($fieldInfo);			
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