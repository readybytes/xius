<div class="mainbox">
	<?php foreach($this->users as $u)	:
		  	$cuser = CFactory::getUser($u->userid); ?>		
	<div class="subbox">
		<div class="head">
			<span class="xiusname"><?php echo $cuser->name;?></span> 
 			<?php echo $cuser->getStatus() ;?>
 		</div>
 			
		<div class="submainbox">
			
			<div class="leftbox">
				<div class="subleftbox">
					<img src="<?php echo $cuser->getThumbAvatar();?>" onclick='location.href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>"'/>
				</div>
				<div class="viewprofile">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>" >
					<button><?php echo JText::_('View Profile'); ?></button></a>
				</div>	
			</div>
			
			<div class="subrightbox">
				<div class="leftsubrightbox">
				<?php 
				if(!empty($this->userprofile))	:
					foreach($this->userprofile[$u->userid] as $up)	:
						if($up['value'] != "") :
							if($up['label']=='Name')
								continue;
				  			echo '<span><b>'.JText::_($up['label']).'</b> : ';
				  			echo $up['value']."</span><br />";
						endif; 
					endforeach;
 				endif;
				?>
				</div>
				<div class="rightsubrightbox">
					<div style="text-align: right">
						<div>
							<?php if($cuser->isOnline()): ?>
									<img src="<?php echo JURI::base().'components/com_xius/assets/images/online.png';?>" />
									<?php echo JText::_('Online');?>						
							<?php else	: ?>
									<img src="<?php echo JURI::base().'components/com_xius/assets/images/offline.png';?>" />
									<?php echo JText::_('Offline');?>
							<?php endif; ?>
						</div>
						
						<div>
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/friends.png';?>" />
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id );?>"><?php echo JText::sprintf( ($cuser->getFriendCount()) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $cuser->getFriendCount());?></a>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="clr"></div>	
	</div>
	<?php endforeach; ?>
</div>

