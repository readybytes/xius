<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

class XiusTableInfo extends JTable
{

	var $id				=	0 ;
	var $labelName		=	'' ;
	var $params			= 	'' ;
	
	var $key			=	'' ;
	var $pluginParams	= 	'' ;
	
	var $pluginType		= 	'' ;
	var $ordering		=	0 ;
	var $published		=	1 ;
	
	function __construct(&$db)
	{
		parent::__construct('#__xius_info','id', $db);
	}
	
	/**
	 * Overrides Joomla's load method so that we can define proper values
	 * upon loading a new entry
	 * 
	 * @param	int	id	The id of the field
	 * @param	boolean isGroup	Whether the field is a group
	 * 	 
	 * @return boolean true on success
	 **/
	function load( $id )
	{
		// ID exist 
		if($id){
			return parent::load( $id );
		}
		return true;
	}

	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store( )
	{
		$db		=& $this->getDBO();
		if( $this->id == 0 )
 		{
 			$query	= 'SELECT COUNT(' . $db->nameQuote('ordering') . ') FROM ' . $db->nameQuote('#__xius_info');
				
 			$db->setQuery( $query );
 			$this->ordering	= $db->loadResult() + 1;
			//print_r("ordering is ".$this->ordering);
 		}
 		parent::store();
 		return $this->id;
	}

}