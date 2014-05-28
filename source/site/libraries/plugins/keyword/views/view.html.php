<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';

class KeywordView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}	
}