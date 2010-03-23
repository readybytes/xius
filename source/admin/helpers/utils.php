<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusHelpersUtils
{
	function isComponentExist($comName,$bothReq=false)
	{
		$frontcompath = JPATH_ROOT.DS.'components'.DS.$comName;
		$admincompath = JPATH_ADMINISTRATOR.DS.'components'.DS.$comName;
		
		if($bothReq) {
			if(JFolder::exists($frontcompath) && JFolder::exists($admincompath))
				return true;
			
			return false;
		}
		
		if(JFolder::exists($frontcompath) || JFolder::exists($admincompath))
			return true;
			
		return false;
	}
	
	
	function getValueFromXiusParams($paramName,$what,$default='')
	{
			return $paramName->get($what,$default);
	}
	
	
	function isTableExist($tableName)
	{
		global $mainframe;
	
		$tables	= array();
		
		$database = &JFactory::getDBO();
		$tables	= $database->getTableList();
	
		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
	}
	
}