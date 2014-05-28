<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once(dirname(__FILE__) . DS . 'defines.php');

class XiusPluginControllerProximity extends JControllerLegacy 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function display($cachable = false, $urlparams = array())
	{
		return 'no Display Function';
    }
    
    
	function getLocationMap($pluginId=null)
    {   	
    	require_once( dirname(__FILE__) . DS . 'googlemaphelper.php' );
    	// use default
   		if($pluginId === null)
    		$pluginId = JRequest::getVar('pluginid',0,'GET');
    	
    	$formName	= JRequest::getVar('fromFormName','userForm','GET');
    	$instance 	= XiusFactory::getPluginInstance('',$pluginId);
    	    	
    	if(!$instance)
    		return false;
   
		require_once(dirname(__FILE__).DS.'views'.DS.'view.html.php');
		$view = new ProximityView();	
		return $view->getLocationMap($formName,$instance);

   }
}