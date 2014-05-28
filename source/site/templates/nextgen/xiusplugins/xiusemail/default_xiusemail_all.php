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
<div id ="xiusEmailToAll" >
<a 
	id="<?php echo $this->buttonMapAll->modalname; ?>" 
	class="<?php echo $this->buttonMapAll->modalname; ?>"
	title="<?php echo $this->buttonMapAll->text; ?>" 
	href="<?php echo $this->buttonMapAll->link; ?>"
	rel="<?php echo $this->buttonMapAll->options; ?>" 
	onClick="return xiusCheckUserSelected()"
>
       	<?php echo XiusText::_("XIUS_EMAIL_ALL");?>
</a>
</div>
<?php 
