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
<div id="xiusTotal">
<span class="xiusTotalText" id="total_<?php echo $this->total;?>">
	<?php echo sprintf(XiusText::_('XIUS_ABOUT_RESULTS_FOUND'),$this->total);?>
</span>
</div>
<?php 
		$count= 0;
		foreach($this->users as $user) : ?>
		  	<div class="xiusMiniProfile">
				<div class="xiusHeader">				
					<?php if(isset($user->email) && !empty($user->email)):?>
						<span class="xiusCheckUser">
							<input type="checkbox" name="xiusCheckUser" id="xiusCheckUser<?php echo $count++; ?>" value="<?php echo $user->id; ?>" > 
						</span>
					<?php endif; ?>
					
				
					<?php if($user->isOnline): ?>
						<div class="xiusOnline" title="<?php echo XiusText::_('ONLINE'); ?>"> 				
							<span>
								<?php echo JString::ucfirst($user->name);?>	 	
							</span>
						</div>					
					<?php else	: ?>
						<div class="xiusOffline" title="<?php echo XiusText::_('OFFLINE'); ?>"> 				
							<span>
						<?php echo JString::ucfirst($user->name);?>
							</span>
						</div>
					<?php endif; ?>
					
				<div class="xiusProfileAction" id="xiusProfileAction_<?php echo $user->id; ?>">
					<div class="xiusMpOptions">
					<span class="xiusOptionsText"><?php echo XiusText::_('OPTION');?></span>
<!--					<img src="components/com_xius/assets/images/options.png" />-->
					<span class="xiusOptionsImg">&nbsp;</span>		
					</div>
					<div class="xiusMpActions" id="xiusMpActions_<?php echo $user->id; ?>">
					<?php if(!empty($user->profileLink)) :?>
					<div class="xiusViewProfile" title="<?php echo XiusText::_('VIEW_USER_PROFILE'); ?>">
						<a href="<?php echo $user->profileLink;?>" >
							<?php echo XiusText::_('VIEW_PROFILE'); ?>
						</a>
					</div>
					<?php endif; ?>

				<!-- Frnd Request-->
				    <?php if(!empty($user->friendReq)) : ?>
					<div class="xiusFriends" title="<?php echo XiusText::_("ADD_AS_FRND");?>">
						<a  <?php echo $user->friendReq; ?>>
							<?php echo XiusText::_('ADD_AS_FRND'); ?>
						</a>
					</div>
					<?php endif;?>
					<?php if(isset($user->email) && !empty($user->email)): 
					           echo $user->email;
							    
					           endif; ?>
						
						</div>
					
					</div>
					
				</div>
			<div class="xiusMpMiddle">
 				<div class="xiusAvatar">
 					<img id="avatar_<?php echo $user->id;?>" src="<?php echo $user->thumbAvatar;?>" onclick='location.href="<?php echo $user->profileLink;?>"'/>
				</div>

				<div class="xiusMpData"><?php if(!empty($user->status)) : ?>
							<span class="xiusHeaderStatus">
								<?php echo $user->status;?>
							</span>
							
					<?php endif; ?>
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
	<?php endforeach;
