<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusPluginControllerXiusexport extends JControllerLegacy
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