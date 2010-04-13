<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusLibrariesInfo
{
	
	public function getInfo($filter='',$join='AND')
	{
		$db			=& JFactory::getDBO();
		
		$filterSql = ''; 
		if(!empty($filter)){
			$filterSql = ' WHERE ';
			$counter = 0;
			foreach($filter as $name => $info) {
				$filterSql .= $counter ? ' '.$join.' ' : '';
				$filterSql .= $db->nameQuote($name).'='.$db->Quote($info);
				$counter++;
			}
		}

		$query = 'SELECT * FROM '.$db->nameQuote('#__xius_info')
				.$filterSql
				.' ORDER BY '.$db->nameQuote('ordering');
				
		$db->setQuery($query);
		$info = $db->loadObjectList();
		
		return $info;
	}
	
}
