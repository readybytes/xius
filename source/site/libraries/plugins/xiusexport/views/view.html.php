<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusexportView extends XiusBaseView
{
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		return false;
	}
	
	function _setAdminToolbar($id, $task = 'export', $option = NULL)
	{
		/*
 		 * get toolbar option for exporting the list in csv format
 		 */
		$option = JRequest::getVar('option','xius');
		$url 	= XiusRoute::_("index.php?option={$option}&view=users&task=export&plugin=xiusexport&pluginid={$id}&usexius=1&format=csv",false);  			 
  		$this->assign('url',$url);  			 			
 		$html  = $this->loadTemplate('toolbar_export'); 			  			
  		XiusHelperToolbar::addToAdminToolbar('csv',$html);
	}
}