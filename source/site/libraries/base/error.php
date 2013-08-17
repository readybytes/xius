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