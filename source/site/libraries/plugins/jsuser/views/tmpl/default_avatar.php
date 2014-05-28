<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$value = "All Users";
  if(JFactory::getApplication()->isAdmin() && $this->value !== false){
	$value = $this->value;
  }
?>
 <div>
      	<label><input type="radio" id="avatar" name="avatar"  value="0" title="Users with avatar" <?php echo ($value == "0")? "checked": "" ;?> />
      		<?php echo XiusText::_('WITH_AVATAR'); ?></label>
      	<label><input type="radio" id="avatar" name="avatar"  value="1" title="Users with default avatar" <?php echo ($value == "1")? "checked": "" ;?>/>
      		<?php echo XiusText::_('WITHOUT_AVATAR'); ?></label>
        <label><input type="radio" id="avatar" name="avatar"  value="All Users" title="All users" <?php echo ($value === 'All Users')? "checked": "" ;?> />
      		<?php echo XiusText::_('ALL_USERS'); ?></label>
</div>
<?php
