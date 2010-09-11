<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteHelperUsers 
{
	function getSerializedData($what)
	{
		return htmlspecialchars(serialize($what),ENT_QUOTES);
	}
	
	function getUnserializedData($what)
	{
		return unserialize(htmlspecialchars_decode($what,ENT_QUOTES));
	}
}
