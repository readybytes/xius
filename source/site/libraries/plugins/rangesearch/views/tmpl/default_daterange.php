<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

echo JHTML::_('behavior.calendar');
echo XiusText::_('RANGESEARCH_FROM').'<br/>'.JHTML::_('calendar', $this->value0, $this->pluginType.$this->key.'_min', $this->pluginType.$this->key.$this->formName.'_min', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19')).'<br />';
echo XiusText::_('RANGESEARCH_TO').'<br/>'.JHTML::_('calendar', $this->value1, $this->pluginType.$this->key.'_max', $this->pluginType.$this->key.$this->formName.'_max', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));