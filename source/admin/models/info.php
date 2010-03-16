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
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_Xius.limitstart', 'limitstart', 0, 'int' );

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
		if ($this->_pagination == null)
			$this->getInfo();
		
		return $this->_pagination;
	}
	
	/**
	 * Returns the Fields
	 *
	 * @return object	JParameter object
	 **/
	function &getInfo()
	{
		global $mainframe;

		static $info;
		
		if( isset( $info ) )
			return $info;

		// Initialize variables
		$db			=& JFactory::getDBO();

		// Get the limit / limitstart
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest('com_Xiuslimitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart	= ($limit != 0) ? ($limitstart / $limit ) * $limit : 0;

		// Get the total number of records for pagination
		$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__xius_info' );
		$db->setQuery( $query );
		$total	= $db->loadResult();

		jimport('joomla.html.pagination');
		
		// Get the pagination object
		$this->_pagination	= new JPagination( $total , $limitstart , $limit );

		$query	= 'SELECT * FROM ' 
				. $db->nameQuote( '#__xipt_aclrules' );
		$db->setQuery( $query , $this->_pagination->limitstart , $this->_pagination->limit );		
		$info	= $db->loadObjectList();
		
		return $info;
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