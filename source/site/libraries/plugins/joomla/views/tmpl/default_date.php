<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

echo JHTML::_('behavior.calendar');
echo JHTML::_('calendar', $this->value, $this->paramsType.$this->key, $this->paramsType.$this->key.$this->formName, '%d-%m-%Y', array('class'=>'inputbox', 'maxlength'=>'19'));
  			