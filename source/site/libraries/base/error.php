<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusError extends JError
{
	const ERROR   = 1;
	const WARNING = 2;

	/**
	 * Assert Check condition true or not.
	 * if $condition false then rais error or warning.
	 */
 	static public function assert($condition, $msg = '', $type = self::ERROR)
	 	{
	 		if($condition){
	 		 	return true;
	 		 }
	 		 if($type == self::ERROR){
	 		 	self::raiseError('XIUS-ERROR', $msg);
	 		 } 		 
	 		self::raiseWarning('XIUS-WARNING', $msg);
		}
	
	
}