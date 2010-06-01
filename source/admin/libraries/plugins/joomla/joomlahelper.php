<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
//defined('_JEXEC') or die('Restricted access');

class Joomlahelper
{

	function getJoomlaFields($filter = '')
	{
		$db	=& JFactory::getDBO();
			
		$userTable = new JTable('#__users','id', $db);
		$allColumns = $userTable->_db->getTableFields('#__users');
		
		if(empty($allColumns))
			return false;
			
		if(empty($allColumns['#__users']))
			return false;
			
		if(!empty($filter))
			return $filter;
			
		return $allColumns['#__users'];
	}
	
	
	function getFieldsHTML($calleObject)
	{
		if($calleObject->get('key') == 'registerDate'){
			
			$document	=& JFactory::getDocument();
			$document->addStyleSheet(JURI::root()."includes/js/calendar/calendar-mos.css");
			$document->addScript(JURI::root()."includes/js/joomla.javascript.js");
			$document->addScript(JURI::root()."includes/js/calendar/calendar_mini.js");
			$document->addScript(JURI::root()."includes/js/calendar/lang/calendar-en-GB.js");
		
			$fieldHTML ='<input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'" id="'.$calleObject->get('pluginType').$calleObject->get('key').'" style="width:125px; margin-right:4px" value="" />';
			$fieldHTML .= '<a href="javascript:void(0)" onclick="return showCalendar(\''.$calleObject->get('pluginType').$calleObject->get('key').'\', \'dd-mm-y\');" ><img src="'.rtrim(JURI::root()).'components/com_community/assets/calendar.png"></a>';
			return $fieldHTML;
		}
		return false;
	}
	
}
