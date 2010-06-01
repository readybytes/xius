<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusHelperUsers 
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