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
	
	
	function getFieldsHTML($calleObject,$value='')
	{
		$paramsType	=	$calleObject->get('pluginType');
 		$key		=	$calleObject->get('key');
 		$infoType	=	Joomla::getCacheSqlSpec($key);
 		
 		if($infoType == 'datetime NOT NULL' ){
  			// if module is displayin info
  			$mySess 	= & JFactory::getSession();
  			$formName	= $mySess->get('xiusModuleForm','','XIUS');
         		if($formName != '')
         			$formName .= "_{$formName}";
         			
 			JHTML::_('behavior.calendar');
             $fieldHTML  = JHTML::_('calendar', $value, $paramsType.$key, $paramsType.$key.$formName, '%d-%m-%Y', array('class'=>'inputbox', 'maxlength'=>'19'));
  			return $fieldHTML;
  		}
  		
 		if($infoType == 'tinyint(4) NOT NULL'){			
 			$fieldHTML  = '<select class="selectbox" name="'.$paramsType.$key.'" id="'.$paramsType.$key.'" value="" />';
  			$fieldHTML .= "<option value=''>".JText::_('SELECT BELOW')."</option><option value='0'>".JText::_('NO')."</option><option value='1'>".JText::_('YES')."</option></select>";
  			return $fieldHTML;
  		}
	}
	
}
