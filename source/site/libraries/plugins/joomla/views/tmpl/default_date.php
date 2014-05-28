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
echo JHTML::_('calendar', $this->value, $this->paramsType.$this->key, $this->paramsType.$this->key.$this->formName, '%d-%m-%Y', array('class'=>'inputbox', 'maxlength'=>'19'));
  			