<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiusModelConfiguration extends JModelLegacy
{ 	 	 
	var $_params;
	var $_xml	= '';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		// Test if ini path is set
		if( empty( $this->_xml ) )
		{
			$this->_xml	= JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'configuration.xml';
		}
		
		// Call the parents constructor
		parent::__construct();
	}
	
	/**
	 * Returns the configuration object
	 *
	 * @return object	XiusParameter object
	 **/	 
	function getParams()
	{
		// Test if the config is already loaded.
		if( !$this->_params )
		{
			jimport( 'joomla.filesystem.file');
			$ini	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_xius' . DS . 'configuration.ini';
			$data	= JFile::read($ini);
			
			$xmlpath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'configuration.xml';
			if(JFile::exists($xmlpath))
				$this->_params = new XiusParameter($data,$xmlpath);
			else 
				$this->_params = new XiusParameter('','');
				
			$config = XiusFactory::getInstance ( 'configuration', 'table');
			$config->load( 'config' );
			
			// Bind the user saved configuration.
			$this->_params->bind( $config->params );
		}
		return $this->_params;
	}
	
	/**
	 * Save the configuration to the config file
	 * 
	 * @return boolean	True on success false on failure.
	 **/
	function save($name,$params)
	{
		jimport('joomla.filesystem.file');

		$config = XiusFactory::getInstance ( 'configuration', 'table');
		$config->load( $name );
		
		$registry	= new JRegistry( 'xius_'.$name );
		
		// serialize the user type who can create list
		// this is done in this onlyfor unilt testing
		if(array_key_exists('xiusListCreator',$params)){
			$temp 		= $params['xiusListCreator'];
			$params['xiusListCreator'] = serialize($temp);		
		}
		
		$registry->loadArray($params,'xius_'.$name);
		// Get the complete INI string
		$config->params	= $registry->toString( 'INI' , 'xius_'.$name );
		$config->name = $name;
		// Save it
		if(!$config->store() )
		{
			return false;
		}
		return true;
	}
	
	
	
	function getOtherParams($name)
	{
		jimport( 'joomla.filesystem.file');
		
		$params = new XiusParameter('','');
			
		$config = XiusFactory::getInstance ( 'configuration', 'table');
		$config->load( $name );
		
		// Bind the saved configuration.
		$params->bind( $config->params );
		
		return $params;
	}
}
