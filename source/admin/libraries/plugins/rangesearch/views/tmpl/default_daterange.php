<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

echo JHTML::_('behavior.calendar');
echo XiusText::_('RANGESEARCH FROM').'<br/>'.JHTML::_('calendar', $this->value0, 'field'.$this->pluginType.$this->key.'_min', 'field'.$this->pluginType.$this->key.'_min', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19')).'<br />';
echo XiusText::_('RANGESEARCH TO').'<br/>'.JHTML::_('calendar', $this->value1, 'field'.$this->pluginType.$this->key.'_max', 'field'.$this->pluginType.$this->key.'_max', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));