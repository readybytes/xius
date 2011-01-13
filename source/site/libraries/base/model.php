<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

/*
 * XiUS-Model class have all genearal model function. 
 */ 

class XiusModel extends JModel
{
	var $_name;
	var $_table;
	var $_pagination = null;
	
	/**
	 * @return model name
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * @return table name
	 */
	public function getTable()
	{
		return $this->_table;
	}
	
	/*
	 * Set Default Pagination State
	 * (We can also make XiusPagination Class)
	 */
	function initPaginationState() 
	{
		$mainframe = JFactory::getApplication();

		// Get the pagination request variables
		$this->_pagination->limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$this->_pagination->limitstart	= $mainframe->getUserStateFromRequest( 'com_xius_infolimitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$this->_pagination->limitstart = 
							($this->_pagination->limit != 0 
								? (floor($this->_pagination->limitstart / $this->_pagination->limit) * $this->_pagination->limit) 
								: 0);

		$this->setState('limit', $this->_pagination->limit);
		$this->setState('limitstart', $this->_pagination->limitstart);
	}
	
	/*
	 * Get All Records
	 */ 
	public function loadRecords($filter='', $join='AND',$reqPagination = true, $limitStart=0, $limit=0)
	{
		//if pagination required then set pagination limits		
		if($reqPagination && $limitStart == 0 && $limit == 0)
		{
			$this->_pagination = $this->getPagination($filter,$join);
			// Set the pagination request variables
			$limitStart = $this->_pagination->limitstart;
			$limit = $this->_pagination->limit;
		}

		//build Query
		$query = new XiusQuery();
		$query = $query->select('*')
					   ->from($this->getTable());
						  
		// If any filteration required in query
		if(!empty($filter)){		   	   
			$this->_buildFilterQuery($query, $filter,$join);
		}
		//get All Records					
		$allRecord = $query->order("`ordering`")
						 ->limit($limit, $limitStart)		
						 ->dbLoadQuery()
						 ->loadObjectList();
						 
		return $allRecord;
	}
	
	/*
	 * @return JPagination object	 	 
	 */	 	

	function getPagination($filter = '',$join = 'AND')
	{
		if($this->_pagination == null)
		 {
		 	$this->initPaginationState();
		 	$query = new XiusQuery();
		 	$query = $query->select("COUNT('*')")
					   	   ->from($this->getTable());
			
			// If any filteration required in query
			if(!empty($filter)){		   	   
				$this->_buildFilterQuery($query, $filter,$join);
			}
				
			$total = $query->order("`ordering`")
						   ->dbLoadQuery()
						   ->loadResult();
			
			jimport('joomla.html.pagination');
			// Get the pagination object
			$this->_pagination	= new JPagination( $total , $this->_pagination->limitstart , $this->_pagination->limit);	
		}
			
		return $this->_pagination;
	}
	
	/*
	 * filteration add with query
	 */
	function _buildFilterQuery(XiusQuery &$query, $filter = '',$join = 'AND')
	{
		foreach($filter as $name => $info)
			{
				$query = $query->where("$name = $info ", $join);
			}
	}
	
	/*
	 * Save Data
	 * @return saved data id.
	 * (like save username save then return 'username' info id )
	 */
	function save($data) {
		
		$tableInstance	= XiusFactory::getInstance( $this->_name , 'Table' );
		$tableInstance->load($data['id']);
		$tableInstance->bind($data);
		//save data
		$id=$tableInstance->store();
		XiusError::assert($id, $this->_db->getErrorMsg());
		return $id;
	}
	
	
	function updateRecord($id, $columName, $value)
	{
		$query = new XiusQuery();
		$query = $query->update($this->getTable())
			  		   ->set("$columName = $value")
			  		   ->where(" id = $id ")
			  		   ->dbLoadQuery();
			  
		XiusError::assert($query->query(), $this->_db->getErrorMsg());	
		
		return true;
	}
	
}
