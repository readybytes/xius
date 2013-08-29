<?php
// Check to ensure this file is included in Joomla!
if(!defined('_JEXEC')) die('Restricted access');

class JElementLimit extends XiusElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'xiusLimit';

	function fetchElement($name, $value, &$node = null, $control_name="")
	{
		$limits = array ();
        // Make the option list
		for ($i = 5; $i <= 30; $i += 5) {
			$limits[] = JHTML::_('select.option', "$i");
		}
		$limits[] = JHTML::_('select.option', '50');
		$limits[] = JHTML::_('select.option', '100');

		// Build the select list
		if(JFactory::getApplication()->isAdmin())
			return JHTML::_('select.genericlist',  $limits, $control_name.'['.$name.']', 'class="inputbox" size="1"', 'value', 'text', $value);

		return JHTML::_('select.genericlist',  $limits, "limit", 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $value);

	}
	
}