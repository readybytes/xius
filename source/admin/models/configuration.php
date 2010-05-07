<?php
/**
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class XiusModelConfiguration extends JModel
{ 	 	 
	var $_params;
	var $_xml	= '';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$mainframe	=& JFactory::getApplication();

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
	 * @return object	JParameter object
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
				$this->_params = new JParameter($data,$xmlpath);
			else 
				$this->_params = new JParameter('','');
				
			$config		=& JTable::getInstance( 'configuration' , 'XiusTable' );
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
	function save()
	{
		jimport('joomla.filesystem.file');

		$config	=& JTable::getInstance( 'configuration' , 'XiusTable' );
		$config->load( 'config' );
		
		$xiusparams	= JRequest::getVar('xiusparams','','post');
		
		$registry	=& JRegistry::getInstance( 'xius' );
		$registry->loadArray($xiusparams,'xius');
		$ini = $registry->toString( 'INI' , 'xius' );
		// Get the complete INI string
		$config->params	= $registry->toString( 'INI' , 'xius' );
		
		// Save it
		if(!$config->store() )
		{
			return false;
		}
		return true;
	}
	
	function reset()
	{
		jimport('joomla.filesystem.file');
				
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row	=& JTable::getInstance( 'configuration' , 'XiusTable' );
		
		$row->load('config');

		// Get the complete INI string
		$row->params = '';
		
		// Save it
		if(!$row->store() )
		{
			return false;
		}
		return true;
	}
}
