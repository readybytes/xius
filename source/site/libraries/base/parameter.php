<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/
if(defined('_JEXEC')===false) die();

/*
 * We have extended JDocument class so that we can control what to do
 * on particular times
 */
jimport('joomla.html.parameter');
class XiusParameter extends JParameter
{
	public function __construct($data = '', $path = '')
	{
		parent::__construct($data, $path);
	}
		
	function render($name = 'params', $group = '_default')
	{
		if (!isset($this->_xml[$group])) {
			return false;
		}
		//XITODO : render form name as div id
		$params = $this->getParams($name, $group);
		ob_start();?>
		<?php JHTML::_('behavior.tooltip'); ?>
		<div class="xiusParameter">

		<?php if ($description = $this->_xml[$group]->attributes('description')) : ?>
			<div class="xiusParameter xiRow" >
				<div class="xiusParameter xiCol">
				<?php echo JText::_($description) ; ?>
				</div>
			</div>
		<?php endif;?>

		<?php foreach ($params as $param) : ?>
			<div class="xiusParameter xiRow" >
				<?php if ($param[0] && $param[0] != '&nbsp;'): ?>
					<div class="xiusParameter xiCol xiColKey">
						<?php echo $param[0]; ?>
					</div>
					<div class="xiusParameter xiCol xiColValue">
						<?php echo $param[1]; ?>
					</div>
				<?php else: ?>
					<div class="xiusParameter xiCol xiColDescription">
						<?php echo $param[1]; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<?php if(count($params) < 1) : ?>
			<div class="xiusParameter xiRow">
				<div class="xiusParameter xiCol"><i>
				<?php JText::_('COM_XIUS_THERE_ARE_NO_PARAMETER_FOR_THIS_ITEM'); ?>
				</i></div>
			</div>
		<?php endif; ?>

		</div>

		<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	function bind($data, $group = '_default')
	{
		if (is_array($data)) {
			return $this->loadArray($data, $group);
		} elseif (is_object($data)) {
			return $this->loadObject($data, $group);
		} else {
			return $this->loadINI($data, $group);
		}
	}
	
	public function loadINI($data, $namespace = null, $options = array())
	{
		//for 1.5 no change in behavior
		if(XIUS_JOOMLA_15){
			return parent::loadINI($data, $namespace, $options);
		}
		
		//for 1.6 or later Joomla version, we will use our own writer
		return $this->loadString($data, 'XiusINI', $options);
	}
}