<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

?>
<a 
	id="<?php echo $this->buttonMapAll->modalname; ?>" 
	class="<?php echo $this->buttonMapAll->modalname; ?>"
	title="<?php echo $this->buttonMapAll->text; ?>" 
	href="<?php echo $this->buttonMapAll->link; ?>"
	rel="<?php echo $this->buttonMapAll->options; ?>" 
	onClick="return xiusCheckUserSelected()"
>
       	<img 
			src="<?php echo JURI::base().'components/com_xius/assets/images/emailall.png'; ?>" 
   			title="<?php echo XiusText::_("XIUS_EMAIL_ALL"); ?>" 
		/>
</a>
<?php  
