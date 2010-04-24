<div class="mainbox">
	<?php foreach($this->users as $u)
		{
			$cuser = CFactory::getUser($u->userid);
	?><div class="subbox"><div class="head">
				<?php if(!empty($this->userprofile)){
					//print_r(var_export($this->userprofile[$u->userid]));
					foreach($this->userprofile[$u->userid] as $up){
						if($up['value'] != ""){
							if($up['label']=='Name'){
							echo "<b>".ucwords($up['value'])."</b><br />";
							continue;
							}
					  	} 
					}
	 			}?></div>
			<?php //echo $u->userid;
				if(!empty($this->userprofile)){
					//print_r(var_export($this->userprofile[$u->userid]));
					foreach($this->userprofile[$u->userid] as $up) :
						if($up['value'] != ""){
							if($up['label']=='Username'){
						 		//		echo ucwords($up['value'])."'s Profile";
						 	}
						}
					endforeach;
				}
			?><div class="submainbox">
			<div class="subleftbox">
				
			<img src="<?php echo $cuser->getThumbAvatar();?>" />
			</div>
			
			<div class="subrightbox"><div class="lsubrightbox"><?php //echo $u->userid;
				if(!empty($this->userprofile)){
					//print_r(var_export($this->userprofile[$u->userid]));
					foreach($this->userprofile[$u->userid] as $up){
						if($up['value'] != ""){
							if($up['label']=='Name'){
							//echo "<b>".$up['value']."</b><br />";
							continue;
							}
					  	echo '<span>'.$up['label'].' : ';
					  	echo $up['value']."</span><br />";
						} 
					}
	 			}
				?></div><div style="float:right;width:29%;">
			<span style="text-align: right"><?php 
						if($cuser->isOnline())
						{
							?>
							<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/online.png';?>" />
							<?php echo "online";						}
						else{?>
							<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/offline.png';?>" />
							<?php echo "offline";
						}
						?>
						<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/friends.png';?>" />
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id );?>"><?php echo JText::sprintf( ($cuser->getFriendCount()) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $cuser->getFriendCount());?></a>
					
			</span></div>
			</div>
			</div>
			<div class="clr"></div>	
			<div class="viewprofile">View Profile</div>				
				
					
		</div>	
	<?php }?>
	 
</div>

