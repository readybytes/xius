<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class ListHelper
{
	function getListData()
	{
		//XITODO : Use library fn to get list
		$db			=& JFactory::getDBO();

		//$filterSql = $this->_buildFilterQuery($filter,$join);
		
		$query	= ' SELECT * FROM ' 
				. $db->nameQuote('#__xius_list')
				//.$filterSql
				. ' ORDER BY '. $db->nameQuote('ordering');
		$db->setQuery($query);
			
		$lists	= $db->loadObjectList();
		return $lists;		
	}
}
