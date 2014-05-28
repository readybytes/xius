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
<input class="inputbox" type="text" name="<?php echo $this->calleObject->get('pluginType').'_'.$this->calleObject->get('id'); ?>"
			 id="<?php echo $this->calleObject->get('pluginType').'_'.$this->calleObject->get('id'); ?>"
			 value = "<?php echo $this->value; ?>"/>

<?php 
