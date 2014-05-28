<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

/*
 * XiUS-Model class have all genearal model function. 
 */ 

class XiusModel extends JModelLegacy
{
	var $_table;
	var $_pagination = null;
	var $_total;
	/**
	 * @return model name
	 */
	public function getName()
	{
		if (empty( $this->_name ))
		{
			$r = null;
			if (!preg_match('/Model(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "XiusModel::getName() : Can't get or parse class name.");
			}
			$this->_name = strtolower( $r[1] );
		}

		return $this->_name;
	}
	
	/**
	 * @return table name
	 */
	public function getTable($name = '', $prefix = 'Table', $options = array())
	{
		return $this->_table;
	}
	
	
	/*
	 * Get All Records
	 */ 
	public function loadRecords($filter='', $join='AND', $reqPagination = true, $limitStart=0, $limit=0, $sort='userid',$dir='ASC')
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
		$this->_query = $this->getQuery($filter,$join,true,$sort,$dir);
			
		//get all records
		$allRecord = $this->_getList((string)$this->_query, $limitStart, $limit);
				 
		return $allRecord;
	}
	
	/*
	 * @return JPagination object	 	 
	 */	 	

	function getPagination($filter = '',$join = 'AND',$sort='userid',$dir='ASC')
	{
		$mainframe  	= JFactory::getApplication();
		
		// take default limit if limit is not set in REQUEST variable
		$endLimit = JRequest::getVar('limit',0);
		$limit    = ( !$endLimit ) 
				      ? $mainframe->getUserStateFromRequest('global.list.limit', 'limit', XiusHelperUtils::getConfigurationParams('xiusLimit'), 'int' ) 
				      : $endLimit;

		if($this->_pagination == null)
		 {
			jimport('joomla.html.pagination');
			
			//Set default value of limitstart
			if(JRequest::getVar('limitstart', null, 'REQUEST') === null){
				JRequest::setVar('limitstart',0, 'POST');
			}
	
			// Get the pagination request variables
			$limitStartStr	= 'com_xius.'.$this->getName().'.limitstart'; 
			//if admin side then always apply joomla's default pagination
			if(JFactory::getApplication() instanceof JAdministrator){
				$limit			= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
			}			
			$limitstart		= $mainframe->getUserStateFromRequest($limitStartStr, 'limitstart', 0, 'int' );
	
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart = ($limit != 0) ? (floor($limitstart / $limit) * $limit) : 0;
	
			$this->setState('limit', $limit);
			$this->setState($limitStartStr, $limitstart);
			
			// Get the pagination object
			$this->_pagination	= new JPagination( $this->getTotal($filter,$join,$sort,$dir) , $limitstart , $limit);	
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
	function getQuery($filter='', $join='AND', $reset=true, $sort='', $dir='')
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
		return $this->_query;
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
		$this->_query = $this->getQuery($filter,$join,false);
        $this->_total = $this->_getListCount((string) $this->_query);

		return $this->_total;
	}
	
	/**
	 * Return All Available Groups
	 */
 	function getGroups()
    {
    	static $groups = null;
    	
    	if($groups !== null)
    		return $groups;
    			
    	$query 	= new XiusQuery();
    	$groups =  $query->select(array('id','name'))
        			  	 ->from("`#__community_groups`")
        			     ->dbLoadQuery()
        			     ->loadObjectList();
    
    	return $groups;
    }

	/**
	 * *
	 * Return true if id exist ...
	 * @param unknown_type $id
	 * @param unknown_type $table
	 */
	
    public function isIdExist($tableName,$filter=array(),$join='AND')
    {
    	if(empty($tableName))
    		return false;
       $query=new XiusQuery();
       $filter=$query->select("*")
                    ->from("`#__xius_"."$tableName`");
       self::_buildFilterQuery($query,$filter,$join);
                    
	   $result = $query->dbLoadQuery()
          			    ->loadObjectList();

        if(!empty($result))
          return true;
        return false;   			
    }
	
}
