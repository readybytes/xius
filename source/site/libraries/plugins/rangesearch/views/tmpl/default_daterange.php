<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

echo JHTML::_('behavior.calendar');
echo XiusText::_('RANGESEARCH_FROM').'<br/>'.JHTML::_('calendar', $this->value0, $this->pluginType.$this->key.'_min', $this->pluginType.$this->key.$this->formName.'_min', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19')).'<br />';
echo XiusText::_('RANGESEARCH_TO').'<br/>'.JHTML::_('calendar', $this->value1, $this->pluginType.$this->key.'_max', $this->pluginType.$this->key.$this->formName.'_max', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));