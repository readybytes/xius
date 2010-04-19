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
	
	function getData()
	{
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
			/*XITODO : Add params1 as argument ,not build here*/
            $params1[1] = 'Male';
			$query = XiusLibrariesUserSearch::buildQuery($params1);
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
        return $this->_data;
  	}
  	
  	function getTotal()
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
			/*XITODO : Add params1 as argument ,not build here*/
            $params1[1] = 'Male';
			$query = XiusLibrariesUserSearch::buildQuery($params1);
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
  	}
  	
  	
  	function getPagination()
  	{
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
  	}
  	
}
