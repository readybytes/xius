<?php

// no direct access
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
	
}