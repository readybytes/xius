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
	var $_table;
	var $_pagination = null;
	var $_total;

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
		// set query element
		$this->getQuery($filter, $join);
		
		//get all records
		$allRecord = $this->_query->limit($limit, $limitStart)		
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
			
			jimport('joomla.html.pagination');
			// Get the pagination object
			$this->_pagination	= new JPagination( $this->getTotal($filter,$join) , $this->_pagination->limitstart , $this->_pagination->limit);	
		}
			
		return $this->_pagination;
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
	/**
	 * update record according data id
	 * @param unknown_type $id:: data_id for condition
	 * @param unknown_type $columName:: update column name for updation 
	 * @param unknown_type $value
	 */
	
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
	
	/**
	 * return query element
	 * @param unknown_type $filter: condition
	 * @param unknown_type $join: match condition
	 */
	function getQuery($filter='', $join='AND', $reset=true)
	{
		if(isset($this->_query) && $reset==false){
			return $this->_query;
		}
		//make query
		$this->_query = new XiusQuery();
		$this->_query = $this->_query->select('*')
					   				 ->from($this->getTable());
						  
		// If any filteration required in query
		if(!empty($filter)){		   	   
			$this->_buildFilterQuery($this->_query, $filter,$join);
		}
		//set order on query element					
		$this->_query->order("`ordering`");
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
	
	/**
	 * return total user
	 * @param unknown_type $filter
	 * @param unknown_type $join
	 */
	
	function getTotal($filter,$join)
	{
		if($this->_total){
			return $this->_total;
		}

		//set query element
		$this->getQuery($filter,$join, false);
        $this->_total 	= $this->_getListCount((string) $this->_query);

		return $this->_total;
	}
	
}
