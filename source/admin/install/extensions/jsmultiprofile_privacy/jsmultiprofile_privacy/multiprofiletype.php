<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class JElementMultiprofiletype extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'multiprofiletypes';
	
	function fetchElement($name, $value , &$node = null, $control_name = 'params' )
	{
       	$mprofileType  = CFactory::getModel('profile');
 		$mprofileTypes = $mprofileType->getProfileTypes();
 		$value		   = unserialize($value);
 		$start = new stdClass();
 		$end   = new stdClass();
 		//add 'All' and 'None' option
 		$start->id   = 0;
		$start->name = "All";
		$end->id     = count($mprofileTypes)+1;
		$end->name 	 = "None";
		array_unshift($mprofileTypes,$start);
		array_push($mprofileTypes,$end);
		
		return JHTML::_('select.genericlist',$mprofileTypes,$control_name.'['.$name.'][]','multiple="multiple" size="'.count($mprofileTypes).'"','id', "name",$value);
 			
	}
}