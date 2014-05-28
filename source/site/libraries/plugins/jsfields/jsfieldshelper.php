<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class Jsfieldshelper
{

	public static function getJomsocialFields($filter = '',$reset = false)
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
		$db	= JFactory::getDBO();
			
		//setting up the search condition is there is any
		$wheres = array();
		if(! empty($filter)){
			foreach($filter as $column => $value)
				$wheres[] = "`$column` = " . $db->Quote($value); 	
		}
			
		$sql = "SELECT * FROM " . $db->quoteName('#__community_fields');
		
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
	
	
	
	public static function getAllJomsocialFields($reset = false)
	{
		static $jsFields;
		
		if(!$reset && isset($jsFields))
			return $jsFields;
		//XiTODO:: USe XiusQuery rather than DBO 	
		$db	= JFactory::getDBO();
		$sql = "SELECT * FROM " . $db->quoteName('#__community_fields');
		$sql .= " ORDER BY `ordering`";
		$db->setQuery($sql);
		$jsFields = $db->loadObjectList();
		
		return $jsFields;
	}
	
	
	/*fieldInfo contain a field information ( like Gender id ,fieldcode etc.
	 * Function will return that field html
	 */
	public static function getFieldsHTML($fieldInfo)
	{
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		$fieldHTML = '';
		
		/*IMP : if change date field data into y-mm-dd ,
		 * then take care of jsfields formatValue function also
		 */
		switch($fieldInfo->type) 
		{
			case 'date':
				$value = '';
				if(isset($fieldInfo->value)){
					$value = $fieldInfo->value;
				}

				$formName	= JFactory::getSession()->get('xiusModuleForm','','XIUS');
	       		if($formName != '')
	       			$formName = "_{$formName}";
	       			
	     		$fieldHTML = JHTML::_('behavior.calendar');
				$fieldHTML .= JHTML::_('calendar',$fieldInfo->value, "field".$fieldInfo->id, "field".$fieldInfo->id.$formName, '%d-%m-%Y', array('class'=>'inputbox', 'maxlength'=>'19'));
				break;  
				
			case 'profiletypes':
				require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
				return ProfiletypesHelper::getFieldHTML($fieldInfo);

			case 'xidepfields' :
				 $mysess = JFactory::getSession();
		 		 $mysess->set('xidepTypeInfo',1);
		 		 $fieldHTML = CProfileLibrary::getFieldHTML($fieldInfo);			
		 		 $mysess->clear('xidepTypeInfo');
		 		 break;
				
			default :
				$fieldHTML = CProfileLibrary::getFieldHTML($fieldInfo);						
		}

		return $fieldHTML;
	}

	public static function getFieldType($fieldId)
	{
		$filter = array();
		$filter['id'] = $fieldId;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo))
			return false;
			
		return $fieldInfo[0]->type;
	}
	
	
	public static function changeValueFormat(&$value, $fType)
	{
		if($fType == 'birthdate' && !empty($value) && is_array($value))
		{		
			$value[0] = (strlen((string)$value[0])==1) ?"0".$value[0] : $value[0] ;
			$value[1] = (strlen((string)$value[1])==1) ? "0".$value[1] : $value[1];
			$value = implode('-',$value); 
		}

		if($fType == 'url'){
			$value = $value[0].$value[1];
		}
		
	}
	
}
