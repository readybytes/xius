<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';

class JFormFieldXiuslist extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	Public	$_name = 'Xiuslist';

	function getInput(){
		$all = new stdClass();
		$all->id = 0;
		$all->name=XiusText::_('all');
		$filter['published'] = 1; 
		$ListTypeArray = XiusLibList::getLists($filter, 'AND', false);
		array_unshift($ListTypeArray,$all);
		return JHTML::_('select.genericlist',  $ListTypeArray, $this->name, null, 'id', 'name', $this->value);
	}
}