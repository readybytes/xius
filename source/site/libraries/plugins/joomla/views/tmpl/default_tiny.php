<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>

<select class="selectbox" name="<?php echo $this->paramsType.$this->key; ?>" id="<?php echo $this->paramsType.$this->key; ?>" />
	<option value=''> <?php echo XiusText::_('SELECT_BELOW')?></option>
	<option value='0' <?php echo (is_numeric($this->value) && $this->value == 0) ? 'selected' : ''; ?>><?php echo XiusText::_('NO'); 		?></option>
	<option value='1' <?php echo (is_numeric($this->value) && $this->value == 1) ? 'selected' : ''; ?>><?php echo XiusText::_('YES'); 		?></option>
</select>
