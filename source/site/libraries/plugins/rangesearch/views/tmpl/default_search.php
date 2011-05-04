<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

echo XiusText::_('RANGESEARCH_FROM');?>
<br/>
<input class="inputbox" type="text" name="<?php echo $this->pluginType.$this->key; ?>_min"
		id="<?php echo $this->pluginType.$this->key; ?>_min" value="<?php echo $this->value0; ?>" /><br /> 

<?php echo XiusText::_('RANGESEARCH_TO'); ?>
<br/>
<input class="inputbox" type="text" name="<?php echo $this->pluginType.$this->key; ?>_max" 
		id="<?php echo $this->pluginType.$this->key; ?>_max" value="<?php echo $this->value1; ?>" />


<?php 			
