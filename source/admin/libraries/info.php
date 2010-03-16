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
				.$filterSql;
				
		$db->setQuery($query);
		$info = $db->loadObjectList();
		
		return $info;
	}
	
	
	
	public function getAllPlugins()
	{
		$path	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins';
	
		jimport( 'joomla.filesystem.folder' );
		$plugins = array();
		$plugins = JFolder::folders($path);
		return $plugins;
	}	
}
