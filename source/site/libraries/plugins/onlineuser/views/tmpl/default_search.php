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
 <div>
 	<label class="radio">
		<input type="radio" id="onlineuser" name="onlineuser"  value="online" title="Online users" /> 
		<?php echo XiusText::_('WHO_S_ONLINE'); ?>
	</label>
	<label class="radio">
		<input type="radio" id="onlineuser" name="onlineuser"  value="offline" title="Offline users"/>
		<?php echo XiusText::_('WHO_S_OFFLINE'); ?>
	</label>
	<label class="radio">
		<input type="radio" id="onlineuser" name="onlineuser"  value="all available" title="All Available users" checked />
		<?php echo XiusText::_('ALL_AVAILABLE'); ?>
	</label>
</div>
<?php 
