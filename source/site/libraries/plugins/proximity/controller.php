<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
require_once(dirname(__FILE__) . DS . 'defines.php');

class XiusPluginControllerProximity extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function display() 
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