<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

class XiusModelUsers extends JModel
{
	protected $_totalusers = null;
	protected $_pagination = null;
	protected $_users = null;

	function __construct()
	{
        parent::__construct();

        global $mainframe;

        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('com_xius_user.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
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

		if(!XiusHelperUtils::isTableExist('xius_cache'))
		{
			XiusLibUsersearch::updateCache();
			if(!XiusHelperUtils::isTableExist('xius_cache')){
	          	 JError::raiseWarning(XiusText::_('Cache table does not exist.'));
			}
		}

        $query = XiusLibUsersearch::buildQuery($params,$join,$sort,$dir);
		$strQuery = $query->__toString();

        if($reqPagination)
        	$this->_users = $this->_getList($strQuery, $this->getState('limitstart'), $this->getState('limit'));
        else
        	$this->_users = $this->_getList($strQuery);

        $this->_totalusers = $this->_getListCount($strQuery);

        /*XITODO : Add error message */
        if($this->_db->_cursor === false) {
          	 JError::raiseWarning(XiusText::_('cache table does not exist. Creating it ' ));
        }

        return $this->_users;
  	}

  	function getTotal($params,$join='AND',$sort='userid',$dir='ASC')
  	{
        if ($this->_totalusers)
        	return $this->_totalusers;

		$query = XiusLibUsersearch::buildQuery($params,$join,$sort,$dir);
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
