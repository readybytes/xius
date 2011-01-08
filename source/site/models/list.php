<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class XiusModelList extends JModel 
{
	var $_pagination;
	
    function __construct() 
    {
    	global $mainframe;
		parent::__construct();
		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_xius.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
    }
	
    
	function &getPagination($filter = '',$join = 'AND')
	{
		global $mainframe;
		if ($this->_pagination == null){

			// Get the limit / limitstart
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest('com_xius_listlimitstart', 'limitstart', 0, 'int');
	
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart	= ($limit != 0) ? ($limitstart / $limit ) * $limit : 0;
			
			$db			=& JFactory::getDBO();
			
			$filterSql = $this->_buildFilterQuery($filter,$join);
		
			$query	= ' SELECT COUNT(*) FROM ' 
				. $db->nameQuote('#__xius_list')
				.$filterSql
				.' ORDER BY '. $db->nameQuote('ordering');
			
			$db->setQuery( $query );
			$total = $db->loadResult();
			
			jimport('joomla.html.pagination');
		
			// Get the pagination object
			$this->_pagination	= new JPagination( $total , $limitstart , $limit );
			
		}
			//$this->getLists();
		
		return $this->_pagination;
	}
	
	
	function getLists($filter = '',$join = 'AND',$reqPagination = true,$limitStart=0 , $limit=0)
	{
		$this->getPagination($filter,$join);
		if($reqPagination && $limitStart == 0 && $limit == 0){
			$limitStart = $this->_pagination->limitstart;
			$limit = $this->_pagination->limit;
		}
		// Initialize variables
		$db			=& JFactory::getDBO();

		$filterSql = $this->_buildFilterQuery($filter,$join);
		
		$query	= ' SELECT * FROM ' 
				. $db->nameQuote('#__xius_list')
				.$filterSql
				. ' ORDER BY '. $db->nameQuote('ordering');
		
		if($reqPagination)
			$db->setQuery( $query , $limitStart , $limit );
		else
			$db->setQuery($query);
			
		$lists	= $db->loadObjectList();
		
		// trigger evevnt
		JPluginHelper::importPlugin('xius');
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnAfterLoadList', array( &$lists ) );
		
		return $lists;
	}
	
	
	function _buildFilterQuery($filter = '',$join = 'AND')
	{
			// Initialize variables
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
		
		return $filterSql;
	}	
	
	function updatePublish($id,$value)
	{
		$db =& JFactory::getDBO();
		$query = 'UPDATE #__xius_list'
		. ' SET `published` ='.$db->Quote($value).''
		. ' WHERE `id`='. $db->Quote($id);
		
		$db->setQuery( $query );
		if (!$db->query())
			return false;
		
		return true;
	}
	
	
	/**
	 * Method to store the fieldvalue
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$row = XiusFactory::getInstance ( 'list', 'table');
		$row->load( $data['id'] );

		// Bind the form fields to the fields value table
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// Store the lists table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return $row->id;
	}
}
?>