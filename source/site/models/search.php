<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class XiusModelSearch extends JModel
{
	
	var $_total = null;
	var $_pagination = null;
	
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
	
	/*XITODO : Rename fn to getUsers */
	function getData($params,$join='AND',$sort='userid',$dir='ASC')
	{
		//Check table existance 
		if(!XiusHelpersUtils::isTableExist('xius_cache'))
			XiusLibrariesUsersearch::updateCache();
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
        	$query = XiusLibrariesUsersearch::buildQuery($params,$join,$sort,$dir);
        	/*global $mainframe;
        	$mainframe->enqueueMessage($query,false);*/        
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
            /*XITODO : Add error message */
            if($this->_db->_cursor === false) {
            	if($this->_db->_errorNum == 1146){
            		/*this error represents cache table does not exist
            		 * create it and again call build query
            		 */		
            		XiusLibrariesUsersearch::updateCache();
            		$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
            	}
            }
        }
        return $this->_data;
  	}
  	
  	function getTotal($params)
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
			$query = XiusLibrariesUserSearch::buildQuery($params);

            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  	}
  	
  	
  	function getPagination($params)
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal($params), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  	}
  	
}
