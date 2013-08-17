<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusPluginControllerXiusexport extends JController 
{

	function __construct($config = array())
	{
		parent::__construct($config);
		
		//register default task
		$this->registerDefaultTask('export');
	}
	
	function export( $pluginId=null, $userId=null, $userSelected=null )
	{
		require_once(dirname(__FILE__).DS.'views'.DS.'view.csv.php');
		$view		= new XiusexportView();
		return $view->export();
	}
}