<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
* Table class
*
* @package          Joomla
* @subpackage		profilestatus
*/ //now run
class XiusTableList extends XiusTable
{

	var $id				= null;
	var $owner			= null;
	var $name			= null;
	var $visibleinfo	= null;
	var $sortinfo		= null;
	var $sortdir		= null;
	var $join			= null;
	var $conditions		= null;
	var $published		= null;
	var $ordering		= null;
	var $description	= null;
	var $params			= null;
	
	function __construct()
	{
		parent::__construct('#__xius_list','id');
	}
	
	function load( $id)
	{
		if($id)
			return parent::load( $id );
		
		$this->id			= 0;
		$this->owner		= 0;
		$this->name			= '';
		$this->visibleinfo	= '';
		$this->sortinfo		= 'userid';
		$this->sortdir		= 'ASC';
		$this->join			= '';
		$this->conditions	= '';
		$this->published	= true;
		$this->ordering		= 0;
		$this->description	= '';
	
		return true;
	}

	
	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store(  )
	{
		$db		=& JFactory::getDBO();		
		if(!$this->owner)
			return false;
			
		//For new records need to update the ordering.
 		if( $this->id == 0 )
 		{
 			// Set the ordering
 			$query	= 'SELECT COUNT(' . $db->nameQuote('ordering') . ') FROM ' . $db->nameQuote('#__xius_list');
			
 			$db->setQuery( $query );
 			$this->ordering	= $db->loadResult();
 		}
		
 		parent::store();
 		return $this->id;
	}

	
	function delete($id)
	{
		return parent::delete($id);
	}
	
	/**
	 * Bind data into object's property
	 * @param	array	data	The data for this field
	 **/
	function bind($data)
	{
		return parent::bind($data);
	}
}

?>