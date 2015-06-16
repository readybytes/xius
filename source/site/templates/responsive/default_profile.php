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
<script type="text/javascript"> 
jQuery(document).ready(function($) {
	$('.xiusMiniProfile').hover(function(){
		$(this).find('.xiusProfileAction').css("background-color","#fff");
	});
	$('.xiusMiniProfile').mouseleave(function(){
		$(this).find('.xiusProfileAction').css("background-color","#ecf0f1");
	});
});

</script>
<?php 
		$count= 0;
		foreach($this->users as $user) : ?>	
			<div class="xiusMiniProfile xius-font-color xius-margin">
				<div class="row-fluid">
					
					<?php if(isset($user->email) && !empty($user->email)):?>
						<span class="pull-left">
							<input type="checkbox" name="xiusCheckUser" style="margin-top:0px; margin-left:2px;" id="xiusCheckUser<?php echo $count++; ?>" value="<?php echo $user->id; ?>" > 
						</span>						
					<?php endif; ?>			
					
					<div class="xiusProfileAction" id="xiusProfileAction_<?php echo $user->id; ?>">
						<div class="xiusMpOptions">
							<span class="xiusOptionsText"><?php echo XiusText::_('OPTION');?></span>
			<!--				<img src="components/com_xius/assets/images/options.png" />-->
							<span class="xiusOptionsImg">&nbsp;</span>		
						</div>
						
						<div class="xiusMpActions small" id="xiusMpActions_<?php echo $user->id; ?>">
							<!-- Frnd Request-->
						    <?php if(!empty($user->friendReq)) : ?>
							<div class="xiusFriends" title="<?php echo XiusText::_("ADD_AS_FRND");?>">
								<a <?php echo $user->friendReq; ?>>
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
				<span>
					<h3><a class="xius-margin text-info" href="<?php echo $user->profileLink;?>" target="__blank"><?php echo JString::ucfirst($user->name);?></a></h3> 	
				</span>
			
				<div class="row-fluid xius-margin">
					<div class="xius-margin span3">
						<?php 
							$avatarShape=XiusHelperUtils::getConfigurationParams('xiusAvatarShape','square');
							if($avatarShape == 'circle'){
							?>
	 							<img class="img-circle" id="avatar_<?php echo $user->id;?>" src="<?php echo $user->thumbAvatar;?>" onclick='location.href="<?php echo $user->profileLink;?>"'/>
	 						<?php }
	 						else{?>
	 							<img id="avatar_<?php echo $user->id;?>" src="<?php echo $user->thumbAvatar;?>" onclick='location.href="<?php echo $user->profileLink;?>"'/>
	 						<?php }?>
	 						<div class="row-fluid">
	 							<?php if($user->isOnline): ?>
									<div class="xiusOnline" title="<?php echo XiusText::_('ONLINE'); ?>"> 				
										<span>
											Online	 	
										</span>
									</div>					
								<?php else	: ?>
									<div class="xiusOffline" title="<?php echo XiusText::_('OFFLINE'); ?>"> 				
										<span>
											Offline
										</span>
									</div>
								<?php endif; ?>
				 			</div>
					</div>
					
					<div class="span9 xius-user-profile"><?php if(!empty($user->status)) : ?>
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
								
						  			<div class="xiusMpInfo span6">
							  			<div class="row-fluid"><?php echo $up['label'][$i]; ?></div>
							  			<div class="row-fluid"><strong><?php echo (strpos($up['value'][$i], ',') === false)?  JText::_($up['value'][$i]): $up['value'][$i]; ?></strong></div>
						  			</div>
						  		
							<?php
									endfor;
								endforeach;
			 				endif;
							?>
					</div>
				</div>
		
			</div>
	<?php endforeach;?>


