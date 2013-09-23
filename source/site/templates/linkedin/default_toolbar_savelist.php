<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>
<a 
	id="<?php echo $this->buttonMap->modalname; ?>" 
	class="<?php echo $this->buttonMap->modalname; ?>"
 	title="<?php echo $this->buttonMap->text; ?>" 
	href="<?php echo $this->buttonMap->link; ?>"
	rel="<?php echo $this->buttonMap->options; ?>" 
>
<?php echo XiusText::_("SAVE_THIS_LIST");?></a>
<?php 
 