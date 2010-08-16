<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>

	<div class="xius_email" >
		<form action="<?php echo JRoute::_('index.php?option=com_xius&task=sendEmail&plugin=xiusemail&pluginid='.$this->data['pluginId'].'&userid='.$this->data['userId'].'&tmpl=component'); ?>" method="POST" id="xiusEmail" onSubmit="javascript: return xiusListSelectUser();">
		
			<div  class="xiusEmailHeader"><span><?php echo JText::_('XIUS EMAIL'); ?></span></div>
			<?php 
			if($this->data['userSelected'] === 'no') : ?>
			  <div class="xiusEmailError"><span id="xiusErrorUserNotSelected"><?php echo JText::_("YOU HAVE NOT SELECTED ANY USER TO EMAIL");?> </span>
			  </div>
			 <?php else : ?> 	
				 <div class="xiusEmailBox">
					
					<div class="xiusEmailEntity">
					  <div class="xiusEmailLabel">
				    	<span><?php echo JText::_('XIUS EMAIL SUBJECT'); ?></span>
				 	  </div>
				 	  <div class="xiusEmailControl">
						<input type="text" name="xiusEmailSubjectEl" id="xiusEmailSubjectEl" value="" class="input_box" size="40" /><br/><br/>
				      </div>
				    </div>
				    
					<div class="xiusEmailEntity">
						<div class="xiusEmailLabel">
						    <span><?php echo JText::_('XIUS EMAIL MESSAGE');?></span>
						</div>
						<div class="xiusEmailControl">
						     <?php echo $this->data['editor']->display( 'xiusEmailMessageEl', '', '525', '270', '60', '20' ); ?>
						</div>
					</div>
				</div>
				
				<input type="hidden" name="xiusSelectedUserid" id="xiusSelectedUserid" value="" />
				
				<div class="xiusEmailFooter"><input type="submit" name="send" value="<?php echo JText::_('XIUS EMAIL SEND'); ?>" /></div>
			 <?php endif;	?>	
		</form>
	</div>
<?php