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
<div class="xius_ul">
<div class="xiusTotal">
<span class="xiusTotalText" id="total_<?php echo $this->total;?>">
	<?php echo sprintf(XiusText::_('XIUS_ABOUT_RESULTS_FOUND'),$this->total);?>
</span>
</div>
<?php 
		$count= 0;
		foreach($this->users as $user) : ?>
		  	<div class="xiusMp">
				<div class="xiusHeader">				
				<?php if(isset($user->email) && !empty($user->email)):?>
				<input type="checkbox" name="xiusCheckUser" id="xiusCheckUser<?php echo $count++; ?>" value="<?php echo $user->id; ?>" > 
				<?php endif; ?>
				
				<?php echo JString::ucfirst($user->name);?>
				<?php if(!empty($user->status)) : ?>
						<span class="xiusHeaderStatus">
							<?php echo $user->status;?>
						</span>
				<?php endif; ?>
					<div class="xiusMpOptions">

					<?php if(!empty($user->profileLink)) :?>
						<a href="<?php echo $user->profileLink;?>" >
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/viewprofile.png';?>" title="<?php echo XiusText::_('VIEW_USER_PROFILE'); ?>" />
						</a>
					<?php endif; ?>

<!-- Frnd Request-->
                    <?php if(!empty($user->friendReq)) : ?>
					<a <?php echo $user->friendReq; ?>>
					<img src="<?php echo JURI::base().'components/com_xius/assets/images/friends.png';?>" title="<?php echo XiusText::_("ADD_AS_FRND");?>" />
					</a>
                     <?php  endif;?>


					<?php if($user->isOnline): ?>
						 	<img  src="<?php echo JURI::base().'components/com_xius/assets/images/online.png';?>" title="<?php echo XiusText::_('ONLINE'); ?>" />
					<?php  else	: ?>
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/offline.png';?>" title="<?php echo XiusText::_('OFFLINE'); ?>" />
					<?php endif; ?>
					
					<?php if(isset($user->email) && !empty($user->email)): 
						 	echo $user->email;
						  endif; ?>

					</div>
			</div>
			<div class="xiusMpMiddle">
 				<div class="xiusMpAvatar">
 					<img id="avatar_<?php echo $user->id;?>" src="<?php echo $user->thumbAvatar;?>" onclick='location.href="<?php echo $user->profileLink;?>"'/>
				</div>

				<div class="xiusMpData">
						<?php
						if(!empty($this->userprofile))	:
							foreach($this->userprofile[$user->id] as $up)	:
								for($i =0 ; $i< count($up['value']); $i++ ) :	
									if(empty($up['value'][$i])):
										continue;
										endif;

									if($up['label'][$i]=='Name') :
										continue;
									endif;
						?>
					  			<div class="xiusMpInfo">
						  			<div class="xiusMplabel"><?php echo $up['label'][$i]; ?></div>
									<div class="xiusMpValue"><?php echo (strpos($up['value'][$i], ',') === false)?  JText::_($up['value'][$i]): $up['value'][$i]; ?></div>
					  			</div>
						<?php
								endfor;
							endforeach;
		 				endif;
						?>
				</div>
			</div>
		   </div>
	<?php endforeach; ?>
</div>
<?php 
