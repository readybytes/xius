<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusModelList extends XiusModel 
{
	
    function __construct() 
    {
		$this->_name  = 'list';
		$this->_table = '#__xius_list';

		// Call the parents constructor
		parent::__construct();
    }
	
  
	
	function getLists($filter = '',$join = 'AND',$reqPagination = true,$limitStart=0 , $limit=0)
	{
		if(!$limit){
			$endLimit = JRequest::getVar('limit',0);
			$limit    = ( !$endLimit ) 
				          ? XiusHelperUtils::getConfigurationParams('xiusLimit') 
				          : $endLimit;
		}

		$lists = $this->loadRecords($filter, $join,$reqPagination, $limitStart= JRequest::getVar('limitstart',$limitStart), $limit);
		
		// trigger evevnt
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'xiusOnAfterLoadList', array( &$lists ) );
		
		return $lists;
	}

	function updatePublish($id,$value)
	{
		$this->updateRecord($id, "published", $value);
		return true;
	}
	
	
	/**
	 * Method to store the fieldvalue
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$row = XiusFactory::getInstance ( 'list', 'table');
		$row->load( $data['id'] );
		// Bind the form fields to the fields value table
		$row->bind($data);
		// Store the lists table to the database
		XiusError::assert($row->store(), $this->_db->getErrorMsg());	
		return $row->id;
	}
}
?>