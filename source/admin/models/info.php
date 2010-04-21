<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiusModelInfo extends JModel
{
	/**
	 * Configuration data
	 * 
	 * @var object	JPagination object
	 **/	 	 	 
	var $_pagination;
	/**
	 * Constructor
	 */
	function __construct()
	{
		global $mainframe;

		// Call the parents constructor
		parent::__construct();

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_xius.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Retrieves the JPagination object
	 *
	 * @return object	JPagination object	 	 
	 **/	 	

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
			$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__xius_info' );
			$db->setQuery( $query );
			$total	= $db->loadResult();
			
			jimport('joomla.html.pagination');
		
			// Get the pagination object
			$this->_pagination	= new JPagination( $total , $limitstart , $limit );
			
		}
			
		return $this->_pagination;
	}
	
	
	
	function getAllInfo($filter = '',$join = 'AND',$reqPagination = true,$limitStart=0 , $limit=0)
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
				. $db->nameQuote('#__xius_info')
				.$filterSql
				. ' ORDER BY '. $db->nameQuote('ordering');

		if($reqPagination)
			$db->setQuery( $query , $limitStart , $limit );
		else
			$db->setQuery($query);
			
		$allInfo	= $db->loadObjectList();
		
		return $allInfo;
	}
	
	
	function getInfo($id = 0)
	{
			
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'info', 'XiusTable' );
		
		$row->load($id);
		return $row;
	}
	
	
	function save($data)
	{
		$infoTable	=& JTable::getInstance( 'info' , 'XiusTable' );
		$infoTable->load($data['id']);
		
		/*XITODO : check key should not be added already*/
		$infoTable->bind($data);
		// Save it
		return $infoTable->store();
	}
	
	
	function updatePublish($id,$value)
	{
		$db 	=& JFactory::getDBO();
		$query 	= 'UPDATE #__xius_info'
				. ' SET `published` ='.$db->Quote($value).''
				. ' WHERE `id`='. $db->Quote($id);
		$db->setQuery( $query );
		if (!$db->query())
			return JError::raiseWarning( 500, $db->getError() );
			
		return true;
	}
}