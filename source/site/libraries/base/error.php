<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

class XiusError extends JError
{
	const ERROR   = 1;
	const WARNING = 2;
	
	function __construct()
	{
		//parent::__construct();
	}

	function assert($condition, $msg = '', $type = self::ERROR)
	{
		if($condition)
			return true;
			
		if($type == self::ERROR)
			self::raiseError('XIUS-ERROR', XiusText_($msg));

		self::raiseWarning('XIUS-WARNING', XiusText_($msg));
	}
	
	
}