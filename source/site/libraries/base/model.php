<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusModel extends JModel
{

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