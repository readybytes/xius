<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

?>
 <div>
      	<input type="radio" id="avatar" name="avatar"  value="0" title="Users with avatar" /> 
      		<?php echo XiusText::_('WITH_AVATAR'); ?>
      	<input type="radio" id="avatar" name="avatar"  value="1" title="Users with default avatar"/>
      		<?php echo XiusText::_('WITHOUT_AVATAR'); ?>
      	<input type="radio" id="avatar" name="avatar"  value="All Users" title="All users" checked />
      		<?php echo XiusText::_('ALL_USERS'); ?>
</div>
<?php
