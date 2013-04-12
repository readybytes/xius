<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class Jsfields extends JsfieldsBase
{
	/*Function will format data in display form on mini profile	 */
	public function _getFormatData($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		/*XITODO : Cache jomsocial fields */
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);

		if(is_array($value) && $value!=array())
				$value = implode(",",$value);
		
		if(empty($fieldInfo))
			return $value;
		
		// convert object into array, this is for Jom Social 2.0
		$field = (array)array_shift($fieldInfo);
		$field['value'] = $value;

		if($field['type'] == 'date'){
			$db 	= &JFactory::getDBO(); 
			$query	= 'SELECT DATE_FORMAT('.$db->Quote($value).', "%d-%m-%Y") AS FORMATED_DATE';
			$db->setQuery($query);
			return $db->loadResult();
		}		
		
		if($field['type'] == 'profiletypes'){
			require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::getFieldData($value);			
		}
		
		//handling email type if exporting users as csv
		if($field['type'] == 'email' && JRequest::getVar('task') == 'export'){
			$field['type'] = 'textbox';
		}

		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		$formatvalue = CProfileLibrary::getFieldData($field);		
		return $formatvalue;
	}
}