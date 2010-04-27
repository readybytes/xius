<div class="mainbox">
	<?php foreach($this->users as $u):
		  	$cuser = CFactory::getUser($u->userid);
	?>		
			<div class="subbox">
				<div class="head">
					<?php echo $cuser->name;?>
	 				<?php echo $cuser->getStatus() ;?>
	 			</div>
				<div class="submainbox">
				<div class="subleftbox">
					<img src="<?php echo $cuser->getThumbAvatar();?>" onclick='location.href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>"'/>
				</div>
				<div class="subrightbox">
					<div class="lsubrightbox">
					<?php 
					if(!empty($this->userprofile)):
						foreach($this->userprofile[$u->userid] as $up):
							if($up['value'] != "") :
								if($up['label']=='Name') :
								//echo "<b>".$up['value']."</b><br />";
								continue;
								endif;
					  		echo '<span>'.$up['label'].' : ';
					  		echo $up['value']."</span><br />";
							endif; 
						endforeach;
	 				endif;
					?>
					</div>
						<div style="float:right;width:29%;margin-top:4px;">
							<span style="text-align: right">
							<?php 
							if($cuser->isOnline())
							{
							?>
								<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/online.png';?>" />
								<?php echo "online";						
							}
							else
							{
							?>
								<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/offline.png';?>" />
								<?php echo "offline";
							}
							?>
							<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/friends.png';?>" />
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id );?>"><?php echo JText::sprintf( ($cuser->getFriendCount()) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $cuser->getFriendCount());?></a>
							</span>
						</div>
				</div>
				</div>
					<div class="clr"></div>	
				<div class="viewprofile">
					<FORM>
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>" >
					<button>View Profile</button></a>
					</FORM>
				</div>				
				
			</div>	
	<?php endforeach; ?>
</div>


