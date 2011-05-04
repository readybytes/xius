<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

?>
 <div>
      	<input type="radio" id="onlineuser" name="onlineuser"  value="online" title="Online users" /> 
      		<?php echo XiusText::_('WHO_S_ONLINE'); ?>
      	<input type="radio" id="onlineuser" name="onlineuser"  value="offline" title="Offline users"/>
      		<?php echo XiusText::_('WHO_S_OFFLINE'); ?>
      	<input type="radio" id="onlineuser" name="onlineuser"  value="all available" title="All Available users" checked />
      		<?php echo XiusText::_('ALL_AVAILABLE'); ?>
</div>
<?php
