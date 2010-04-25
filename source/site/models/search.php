<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class XiusModelSearch extends JModel
{
	
	protected $_total = null;
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
	
	
	function getUsers($params,$join='AND',$sort='userid',$dir='ASC')
	{
		if($this->_users)
			return $this->_users;
		
		//Check table existance
		/*XITODO : get table name from cache object */ 
		if(!XiusHelpersUtils::isTableExist('xius_cache'))
			XiusLibrariesUsersearch::updateCache();
			
        $query = XiusLibrariesUsersearch::buildQuery($params,$join,$sort,$dir);        
        $this->_users = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
        /*XITODO : Add error message */
        if($this->_db->_cursor === false) {
          if($this->_db->_errorNum == 1146){
            /*this error represents cache table does not exist
             * create it and again call build query
             */		
            XiusLibrariesUsersearch::updateCache();
            $this->_users = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
          }
        }
        
        return $this->_users;
  	}
  	
  	function getTotal($params)
  	{
        if ($this->_total)
        	return $this->_total;
        	
		$query = XiusLibrariesUsersearch::buildQuery($params);

        $this->_total = $this->_getListCount($query);    

       	return $this->_total;
  	}
  	
  	
  	function getPagination($params)
  	{
        if ($this->_pagination)
        	return $this->_pagination;
        	
        jimport('joomla.html.pagination');
        $this->_pagination = new JPagination($this->getTotal($params), $this->getState('limitstart'), $this->getState('limit') );
        
        return $this->_pagination;
  	}
  	
}
