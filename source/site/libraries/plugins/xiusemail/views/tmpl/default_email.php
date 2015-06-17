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

<div class="container-fluid xius_email">
	<form action="<?php echo XiusRoute::_('index.php?option=com_xius&task=sendEmail&plugin=xiusemail&pluginid='.$this->data['pluginId'].'&userid='.$this->data['userId'].'&tmpl=component'); ?>" method="POST" id="xiusEmail" onSubmit="javascript: return xiusListSelectUser();">
		<div class="row-fluid xiusEmailHeader">
			<span><?php echo XiusText::_('XIUS_EMAIL'); ?></span>
		</div>
		<?php 
			if($this->data['userSelected'] === 'no' || empty($this->data['resultUsers'])) : ?>
				<div class="row-fluid xiusEmailError text-center">
					<span id="xiusErrorUserNotSelected"><?php echo XiusText::_("YOU_HAVE_NOT_SELECTED_ANY_USER_TO_EMAIL");?> </span>
				</div>
			<?php else : ?>
				 <div class="xiusEmailBox">
				 	<div class="row-fluid">
				 		<div class="xiusEmailLabel">
				    		<strong><span><?php echo XiusText::_('XIUS_EMAIL_SUBJECT'); ?></span></strong>
				 	  	</div>
				 	  	<div class="xiusEmailControl">
							<input type="text" name="xiusEmailSubjectEl" id="xiusEmailSubjectEl" value="" class="input_box" size="40" />
					    </div>
				 	</div>
				 	
				 	<div class="row-fluid">
						<div class="xiusEmailLabel">
						    <strong><span><?php echo XiusText::_('XIUS_EMAIL_MESSAGE');?></span></strong>
						</div>
						<div class="xiusEmailControl">
						     <?php echo $this->data['editor']->display( 'xiusEmailMessageEl', '', '525', '270', '60', '20',false ); ?>
						</div>
					</div>
				 </div>
				 
				 <input type="hidden" name="xiusSelectedUserid" id="xiusSelectedUserid" value="" />
				 
				 <div class="row-fluid xiusEmailFooter">
					<input type="submit" name="send" value="<?php echo XiusText::_('XIUS_EMAIL_SEND'); ?>" />
					<input type="submit" name="sendmsg" value="<?php echo XiusText::_('XIUS_MSG_SEND'); ?>" />
				 </div>
			<?php endif;	?>
	</form>
</div>
<?php 
