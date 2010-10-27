<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div id="xiusTotal">
<span class="xiusTotalText" id="total_<?php echo $this->total;?>">
	<?php echo sprintf(XiusText::_('Xius About results found'),$this->total);?>
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
						<div class="xiusOnline" title="<?php echo XiusText::_('Online'); ?>"> 				
							<span>
								<?php echo JString::ucfirst($user->name);?>	 	
							</span>
						</div>					
					<?php else	: ?>
						<div class="xiusOffline" title="<?php echo XiusText::_('Offline'); ?>"> 				
							<span>
						<?php echo XiusText::_(JString::ucfirst($user->name));?>
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
					<div class="xiusViewProfile" title="<?php echo XiusText::_('VIEW USER PROFILE'); ?>">
						<a href="<?php echo $user->profileLink;?>" >
							<?php echo XiusText::_('VIEW PROFILE'); ?>
						</a>
					</div>
					<?php endif; ?>

					<?php if(!empty($user->messageHref)) :
							$onlineUser = JFactory::getUser();
					        if($onlineUser->id != 0 && $onlineUser->id != $user->id): ?>
								<div class="xiusWriteMsg" title="<?php echo XiusText::_('WRITE MESSAGE'); ?>">
									<a <?php echo $user->messageHref; ?> >
										<?php echo XiusText::_('MESSAGE'); ?>
									</a>
								</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if(!empty($user->friendHref)) : ?>
						<div class="xiusFriends" title="<?php echo XiusText::sprintf( ($user->friendCount) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $user->friendCount);?>">
							<a <?php echo $user->friendHref; ?>>
								<?php echo XiusText::_('FRIENDS'); ?>
							</a>
						</div>
					<?php endif; ?>

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
									if($up['value'][$i] == "") :
										continue;
										endif;

									if($up['label'][$i]=='Name') :
										continue;
									endif;
						?>
					  			<div class="xiusMpInfo">
						  			<div class="xiusMplabel"><?php echo XiusText::_($up['label'][$i]); ?></div>
						  			<div class="xiusMpValue"><?php echo XiusText::_($up['value'][$i]); ?></div>
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