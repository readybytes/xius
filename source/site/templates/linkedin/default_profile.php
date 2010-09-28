<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div id="xiusProfile">
<?php 
$count=0;
foreach($this->users as $user) :
?>
<div class="miniProfile">
<?php if(isset($user->email) && !empty($user->email)):?>
						<span class="xiusCheckUser">
							<input type="checkbox" name="xiusCheckUser" id="xiusCheckUser<?php echo $count++; ?>" value="<?php echo $user->id; ?>" > 
						</span>
					<?php endif; ?>
<div class="miniProfileAvatar">
	<img id="avatar_<?php echo $user->id;?>" src="<?php echo $user->thumbAvatar;?>" onclick='location.href="<?php echo $user->profileLink;?>"'/>
</div>
<div class="miniProfileInfos">
<h2 class=mPName><?php  
echo XiusText::_(JString::ucfirst($user->name));
?>
</h2>

<?php 
if(!empty($this->userprofile))	:
	foreach($this->userprofile[$user->id] as $up):	
		for($i =0 ; $i< count($up['value']); $i++ ) :	
			if($up['value'][$i] == "") :
				continue;
			endif;

			if($up['label'][$i]=='Name') :
			continue;
			endif; ?>
			
			<div class="miniProfileInfo">
				<span class="infoLabel"><?php echo XiusText::_($up['label'][$i]); ?></span>
				<span class="infoValue"><?php echo XiusText::_($up['value'][$i]); ?></span>
			</div>
			<?php
		endfor;
	endforeach;
endif;?>
</div>
<div class="miniProfileOptions">
<?php if(!empty($user->profileLink)) :?>
						<a href="<?php echo $user->profileLink;?>" >
							<?php echo XiusText::_('VIEW PROFILE'); ?>
						</a>
						<?php endif; ?>
<br />
						<?php if(!empty($user->messageHref)) :
							$onlineUser = JFactory::getUser();
					        if($onlineUser->id != 0 && $onlineUser->id != $user->id): ?>
						
									<a <?php echo $user->messageHref; ?> >
										<?php echo XiusText::_('MESSAGE'); ?>
									</a>
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
<?php 
endforeach;
?>
</div>
<?php 