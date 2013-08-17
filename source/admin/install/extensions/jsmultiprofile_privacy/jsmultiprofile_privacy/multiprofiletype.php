<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementMultiprofiletype extends JElement
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