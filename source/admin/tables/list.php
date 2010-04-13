<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
* Table class
*
* @package          Joomla
* @subpackage		profilestatus
*/ //now run
class XiusTableList extends JTable
{

	var $id				= null;
	var $owner			= null;
	var $name			= null;
	var $visibleinfo	= null;
	var $sortinfo		= null;
	var $join			= null;
	var $published		= null;
	var $ordering		= null;
	var $description	= null;
	
	function __construct(&$db)
	{
		parent::__construct('#__xius_list','id', $db);
	}
	
	function load( $id)
	{
		if($id)
			return parent::load( $id );
		
		$this->id			= 0;
		$this->owner		= JFactory::getUser()->id;
		$this->name			= '';
		$this->visibleinfo	= '';
		$this->sortinfo		= '';
		$this->join			= '';
		$this->published	= true;
		$this->ordering		= 0;
		$this->description	= '';
	
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
			$this->id			= $data['id'];
			$this->name			= $data['name'];
			$this->fieldid		= $data['fieldid'];
			$this->sort			= $data['sort'];
			$this->join			= $data['join'];
			$this->published	= $data['published'];
			$this->description	= $data['description'];
			
			return parent::bind($data);
	}
}

?>