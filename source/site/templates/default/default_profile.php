<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_ul">
<div class="xiusTotal">
<span class="xiusTotalText" id="total_<?php echo $this->total;?>">
	<?php echo sprintf(XiusText::_('Xius About results found'),$this->total);?>
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
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/viewprofile.png';?>" title="<?php echo XiusText::_('View User Profile'); ?>" />
						</a>
					<?php endif; ?>

					<?php if(!empty($user->friendHref)) : ?>
						<a <?php echo $user->friendHref; ?>>
						<img src="<?php echo JURI::base().'components/com_xius/assets/images/friends.png';?>" title="<?php echo XiusText::sprintf( ($user->friendCount) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $user->friendCount);?>" />
						</a>
					<?php endif; ?>


					<?php if($user->isOnline): ?>
						 	<img  src="<?php echo JURI::base().'components/com_xius/assets/images/online.png';?>" title="<?php echo XiusText::_('Online'); ?>" />
					<?php  else	: ?>
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/offline.png';?>" title="<?php echo XiusText::_('Offline'); ?>" />
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
	<?php endforeach; ?>
</div>
<?php 
