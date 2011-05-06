<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>

<div id="xiusEmailToSelected"><a 
	id="<?php echo $this->buttonMapSel->modalname; ?>" 
	class="<?php echo $this->buttonMapSel->modalname; ?>"
	title="<?php echo $this->buttonMapSel->text; ?>" 
	href="<?php echo $this->buttonMapSel->link; ?>"
	rel="<?php echo $this->buttonMapSel->options; ?>" 
	onClick="return xiusCheckUserSelected()"
>
<?php echo XiusText::_("XIUS_EMAIL_TO_SELECTED"); ?>
</a>
</div>
<?php  
