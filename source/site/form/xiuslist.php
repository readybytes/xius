<?php

// Check to ensure this file is included in Joomla!
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