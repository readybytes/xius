<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
 
$count=0;
foreach($this->users as $user) :?>
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
echo JString::ucfirst($user->name);
?>
</h2>

<?php 
if(!empty($this->userprofile))	:
	foreach($this->userprofile[$user->id] as $up):	
		for($i =0 ; $i< count($up['value']); $i++ ) :	
			if(empty($up['value'][$i])):
				continue;
			endif;

			if($up['label'][$i]=='Name') :
			continue;
			endif; ?>
			
			<div class="miniProfileInfo">
				<span class="infoLabel"><?php echo $up['label'][$i]; ?></span>
				<span class="infoValue"><?php echo (strpos($up['value'][$i], ',') === false)?  JText::_($up['value'][$i]): $up['value'][$i]; ?></span>
			</div>
			<?php
		endfor;
	endforeach;
endif;?>
</div>
<div class="miniProfileOptions">
<?php if(!empty($user->profileLink)) :?>
						<a href="<?php echo $user->profileLink;?>" >
							<?php echo XiusText::_('VIEW_PROFILE'); ?>
						</a>
						<?php endif; ?>
<br />
		<!-- Frnd Request-->
		<?php if(!empty($user->friendReq)) : ?>
					<div class="xiusFriends" title="<?php echo XiusText::_("ADD_AS_FRND");?>">
						<a <?php echo $user->friendReq; ?>>
							<?php echo XiusText::_('ADD_AS_FRND'); ?>
						</a>
					</div>
		<?php  endif;?>

		<?php if(isset($user->email) && !empty($user->email)): 
		           echo $user->email." Mail";
			  endif; ?>
</div>
</div>
<?php 
endforeach;
?>
<?php 
