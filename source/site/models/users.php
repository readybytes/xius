<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class XiusModelUsers extends JModel
{
	
	protected $_totalusers = null;
	protected $_pagination = null;
	protected $_users = null;
	
	function __construct()
	{
        parent::__construct();
 
        global $mainframe, $option;
 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
	}
	
	
	function getUsers($params,$join='AND',$sort='userid',$dir='ASC',$reqPagination=true)
	{
		if($this->_users)
			return $this->_users;
		
		//Check table existance
		/*XITODO : get table name from cache object */ 
		if(!XiusHelpersUtils::isTableExist('xius_cache'))
			XiusLibrariesUsersearch::updateCache();
			
        $query = XiusLibrariesUsersearch::buildQuery($params,$join,$sort,$dir); 
		$strQuery = $query->__toString();
        
        if($reqPagination)       
        	$this->_users = $this->_getList($strQuery, $this->getState('limitstart'), $this->getState('limit'));
        else
        	$this->_users = $this->_getList($strQuery);
        /*XITODO : Add error message */
        if($this->_db->_cursor === false) {
          if($this->_db->_errorNum == 1146){
            /*this error represents cache table does not exist
             * create it and again call build query
             */		
            XiusLibrariesUsersearch::updateCache();
            //$this->_users = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
             if($reqPagination)       
        		$this->_users = $this->_getList($strQuery, $this->getState('limitstart'), $this->getState('limit'));
        	else
        		$this->_users = $this->_getList($strQuery);
          }
        }
        
        return $this->_users;
  	}
  	
  	function getTotal($params,$join='AND',$sort='userid',$dir='ASC')
  	{
        if ($this->_totalusers)
        	return $this->_totalusers;
        	
		$query = XiusLibrariesUsersearch::buildQuery($params,$join,$sort,$dir);
		$strQuery = $query->__toString();
		
        $this->_totalusers = $this->_getListCount($strQuery);    

       	return $this->_totalusers;
  	}
  	
  	
  	function getPagination($params,$join='AND',$sort='userid',$dir='ASC')
  	{
        if ($this->_pagination)
        	return $this->_pagination;
        	
        jimport('joomla.html.pagination');
        $this->_pagination = new JPagination($this->getTotal($params,$join,$sort,$dir), $this->getState('limitstart'), $this->getState('limit') );
        
        return $this->_pagination;
  	}
  	
}
