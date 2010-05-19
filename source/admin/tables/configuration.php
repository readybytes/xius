<?php
/**
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Jom Social Table Model
 */
class XiusTableConfiguration extends JTable
{
	var $name		= null;
	var $params		= null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__xius_config' , 'name' , $db );
	}
	
	/**
	 * Save the configuration
	 **/	 	
	function store()
	{
		$db		=& $this->getDBO();
		
		$query	= 'SELECT COUNT(*) FROM ' . $db->nameQuote( '#__xius_config') . ' '
				. 'WHERE ' . $db->nameQuote( 'name' ) . '=' . $db->Quote( $this->name );
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