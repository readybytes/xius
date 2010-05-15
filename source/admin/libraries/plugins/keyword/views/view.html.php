<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class KeywordView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}	
}
