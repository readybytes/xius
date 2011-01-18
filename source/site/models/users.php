<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

class XiusModelUsers extends XiusModel
{
	protected $_totalusers = null;
	protected $_users = null;

	function __construct()
	{
		//Set default value of limitstart
		JRequest::setVar('limitstart', 0, '', 'int');
		
		// Parent Constructor call (IMP:: its call always before pagination set)
        parent::__construct();
        // Set pagination 
		$this->initPaginationState();
	}
	
	/**
	 * return all users according to Params (Search conditions) 
	 * @param $params is condition
	 * @param $join: Match conditon
	 * @param $sort: sort condition
	 * @param $dir : direction
	 * @param $reqPagination
	 */
	function getUsers($params,$join='AND',$sort='userid',$dir='ASC',$reqPagination=true)
	{
		if(isset($this->_users)){
			return $this->_users;
		}

        $strQuery = XiusLibUsersearch::buildQuery($params,$join,$sort,$dir);

        if($reqPagination)
        	$this->_users = $this->_getList($strQuery, $this->getState('limitstart'), $this->getState('limit'));
        else
        	$this->_users = $this->_getList($strQuery);

        $this->_totalusers = $this->_getListCount($strQuery);

        // XiusError::assert($this->_db->_cursor,'cache table does not exist. Creating it ');
        return $this->_users;
  	}

  	/**
  	 * return total-users according to Search -condition. (Params)
  	 * @param $params: search-condition
  	 * @param $join: match condition
  	 * @param $sort: sort condition
  	 * @param $dir: direction
  	 */
  	function getTotal($params,$join='AND',$sort='userid',$dir='ASC')
  	{
        if(isset($this->_totalusers)){
        	return $this->_totalusers;
        }

		$strQuery = XiusLibUsersearch::buildQuery($params,$join,$sort,$dir);

        $this->_totalusers = $this->_getListCount($strQuery);
       	return $this->_totalusers;
  	}


  	/**
  	 * return pagination object
  	 * @param $params: search-condition
  	 * @param $join: match condition
  	 * @param $sort: sort condition
  	 * @param $dir: direction
  	 */
  	function getPagination($params,$join='AND',$sort='userid',$dir='ASC')
  	{
  		if(empty($this->_pagination)){
  			$this->_pagination = new stdClass();
  			$this->_pagination->limitstart=$this->getState('limitstart'); 
  			$this->_pagination->limit=$this->getState('limit');	
  		}
       jimport('joomla.html.pagination');

       $this->_pagination = new JPagination($this->getTotal($params,$join,$sort,$dir), $this->_pagination->limitstart, $this->_pagination->limit);
       return $this->_pagination;
  	}
  	
	/**
	 * return (string)query
	 * @param unknown_type $params
	 * @param unknown_type $join
	 * @param unknown_type $sort
	 * @param unknown_type $dir
	 * @return XiusQuery 
	 */
	function getQuery($params,$join='AND',$sort='userid',$dir='ASC')
	{
		/*XITODO:  provide conditional operator also
		 * */
		//$dispatcher =& JDispatcher::getInstance();
//		$data = array();
//		$data['conditions'] = &$params;
//		$data['join'] = &$join;
//		$data['sort'] = &$sort;
//		$data['dir']  = &$dir;
		// "onBeforeUserSearchQueryBuild" not exists
		//$dispatcher->trigger( 'onBeforeUserSearchQueryBuild', array( $data ) );
		
		//query initialize
		$query = new XiusQuery();		
		$cache = XiusFactory::getInstance('cache');
		$tableName = $cache->getTableName();
		
		XiusError::assert($tableName,"NO TABLE TO SEARCH");

		// convert into database formate, table name and column
		$db	  = JFactory::getDBO();
		$sort = $db->nameQuote($sort);
		$tableName = $db->nameQuote($tableName);
			
		//Build Query
		$query->select('*')
			  ->from("$tableName");
		/*if no parameter to search then return all users
		 * without any condition
		 * XITODO : add block condition
		 */
		if(!empty($params)){
			self::_buildQuery($query, $params, $join);
		}	

		$query->order("$sort".' '.$dir);
		
		/*Trigger event */
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onAfterUserSearchQueryBuild', array( &$query ) );
			
		return $query->__toString();
	}
	
	/**
	 * build query according condition (params)
	 * @param XiusQuery $query
	 * @param unknown_type $params: Search condition
	 * @param unknown_type $join: match condition
	 */
	function _buildQuery(XiusQuery &$query, $params, $join)
	{
		foreach($params as $p){
			/* value can be array or single , depends on plugin 
		 	*  and we will store data only store data ( as value ) 
		 	* only according to plugin , so they will get data as they want
		 	*/
			$instance = XiusFactory::getPluginInstance('',$p['infoid']);
			if(!$instance){
				continue;
			}
			$instance->addSearchToQuery($query,$p['value'],$p['operator'],$join);
		}
	}
}
