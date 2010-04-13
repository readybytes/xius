<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

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
	
    
	function &getPagination()
	{
		global $mainframe;
		if ($this->_pagination == null){

			// Get the limit / limitstart
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest('com_xiuslimitstart', 'limitstart', 0, 'int');
	
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart	= ($limit != 0) ? ($limitstart / $limit ) * $limit : 0;
			
			$db			=& JFactory::getDBO();
			
			// Get the total number of records for pagination
			$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__xius_list' );
			$db->setQuery( $query );
			$total	= $db->loadResult();
			
			jimport('joomla.html.pagination');
		
			// Get the pagination object
			$this->_pagination	= new JPagination( $total , $limitstart , $limit );
			
		}
			//$this->getLists();
		
		return $this->_pagination;
	}
	
	
	function getLists($filter = '',$join = 'AND',$reqPagination = true,$limitStart=0 , $limit=0)
	{
		$this->getPagination();
		if($reqPagination && $limitStart == 0 && $limit == 0){
			$limitStart = $this->_pagination->limitstart;
			$limit = $this->_pagination->limit;
		}
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
		
		$query	= ' SELECT * FROM ' 
				. $db->nameQuote('#__xius_list')
				.$filterSql
				. ' ORDER BY '. $db->nameQuote('ordering');

		if($reqPagination)
			$db->setQuery( $query , $limitStart , $limit );
		else
			$db->setQuery($query);
			
		$lists	= $db->loadObjectList();
		
		return $lists;
	}
	
	
	function getList($id = 0)
	{
			
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'list', 'XiusTable' );
		
		$row->load($id);
		return $row;
	}
	
	
	function getConditions($id)
	{
		$db			=& JFactory::getDBO();
		$query = 'SELECT * FROM'.' '
				. $db->nameQuote('#__xius_conditions').' '
				.'WHERE `id`='.$db->Quote($id);
				
		$db->setQuery( $query );
		$conditions	= $db->loadObjectList();
		return $conditions;
	}
	
	
	function updatePublish($id,$value)
	{
		global $mainframe;
		$db =& JFactory::getDBO();
		$query = 'UPDATE #__xius_list'
		. ' SET `published` ='.$db->Quote($value).''
		. ' WHERE `id`='. $db->Quote($id);
		
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getError() );
		}
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
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'list', 'XiusTable' );
		
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
	

	function removeConditions($id)
	{
		global $mainframe;
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

		$rows	= $this->getConditions($id);
		
		$count = 0;
		if(!empty($rows)){
			$table	=& JTable::getInstance( 'conditions', 'XiusTable' );
			
			foreach( $rows as $row ){
				$table->load( $row->id );
				$table->delete( $row->id );
				$count++;
			}
		}
		
		return $count;
	}
}
?>