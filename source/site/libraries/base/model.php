<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusModel extends JModel
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	/*
	 * Return Model Instance
	 */
	function getModel( $name, $reset=false )
	{
		static $modelInstances = null;

		$className = 'XiusModel'.JString::ucfirst($name);

		if(!$reset && isset($modelInstances[$className]))
			return $modelInstances[$className];

		//check for classname
		if(class_exists($className, true)===false)
		{
			XiusError::assert(false, "Class $className not found", 1);
			return false;
		}

		$modelInstances[$className] = new $className;
		return $modelInstances[$className];
	}
	

//	function getPagination($filter = '',$join = 'AND')
//	{
//		global $mainframe;
//		if ($this->_pagination == null){
//
//			// Get the limit / limitstart
//			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
//			$limitstart	= $mainframe->getUserStateFromRequest('com_xius_listlimitstart', 'limitstart', 0, 'int');
//	
//			// In case limit has been changed, adjust limitstart accordingly
//			$limitstart	= ($limit != 0) ? ($limitstart / $limit ) * $limit : 0;
//			
//			$db			=& JFactory::getDBO();
//			
//			$filterSql = $this->_buildFilterQuery($filter,$join);
			
//			$query = new XiusQuery();
//			$query->select('*')
//				   ->from()
//		
//			$query	= ' SELECT COUNT(*) FROM ' 
//				. $db->nameQuote('#__xius_list')
//				.$filterSql
//				.' ORDER BY '. $db->nameQuote('ordering');
//			
//			$db->setQuery( $query );
//			$total = $db->loadResult();
//			
//			jimport('joomla.html.pagination');
//		
//			// Get the pagination object
//			$this->_pagination	= new JPagination( $total , $limitstart , $limit );
//			
//		}
//			//$this->getLists();
//		
//		return $this->_pagination;
//	}
}