<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class ForcesearchView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		return false;
	}
	
	function rawDataHtml(XiusBase $calleObject)
	{

		$this->setLayout('rawdata');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		
		$info = $calleObject->getAvailableInfo();
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}
}