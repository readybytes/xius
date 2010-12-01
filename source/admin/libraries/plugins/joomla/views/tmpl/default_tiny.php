<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>

<select class="selectbox" name="<?php echo $this->paramsType.$this->key; ?>" id="<?php echo $this->paramsType.$this->key; ?>" />
	<option value=''> <?php echo XiusText::_('SELECT BELOW')?></option>
	<option value='0' <?php echo (is_numeric($this->value) && $this->value == 0) ? 'selected' : ''; ?>><?php echo XiusText::_('NO'); 		?></option>
	<option value='1' <?php echo (is_numeric($this->value) && $this->value == 1) ? 'selected' : ''; ?>><?php echo XiusText::_('YES'); 		?></option>
</select>
