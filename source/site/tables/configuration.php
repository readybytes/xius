<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

/**
 * Jom Social Table Model
 */
class XiusTableConfiguration extends XiusTable
{
	var $name		= null;
	var $params		= null;
	
	function __construct()
	{
		parent::__construct( '#__xius_config' , 'name' );
	}
	
	/**
	 * Save the configuration
	 **/	 	
	function store($updateNulls = false) 
	{
		$db		= $this->getDBO();
		
		$query	= 'SELECT COUNT(*) FROM ' . $db->quoteName( '#__xius_config') . ' '
				. 'WHERE ' . $db->quoteName( 'name' ) . '=' . $db->Quote( $this->name );
		$db->setQuery( $query );
		
		$count	= $db->loadResult();

		$data	= new stdClass();
		$data->name		= $this->name;
		$data->params	= $this->params;
		
		if( $count > 0 )
			return $db->updateObject( '#__xius_config' , $data , 'name' );

		return $db->insertObject( '#__xius_config' , $data );
	}
}