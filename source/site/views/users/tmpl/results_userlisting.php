<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xiusListing">
<?php
	 foreach($this->users as $u)	:
	 		JTable::addIncludePath( JPATH_ROOT .DS.'administrator'.DS.'components'.DS.'com_community' . DS . 'tables' );
		  	$cuser = CFactory::getUser($u->userid); ?>		
	<div class="xiusProfile">
		<div class="xiusTopBar">
			<span class="xiusname"><?php echo JText::_($cuser->name);?></span> 
 			<?php echo JText::_($cuser->getStatus()) ;?>
 		</div>
 			
		<div class="xiusProfileArea">
			
			<div class="xiusProfileLeft">
				<div class="xiusAvatar">
					<img id="avatar_<?php echo $cuser->id;?>" src="<?php echo $cuser->getThumbAvatar();?>" onclick='location.href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>"'/>
				</div>
				<div class="xiusViewProfile">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>" >
					<button><?php echo JText::_('View Profile'); ?></button></a>
				</div>	
			</div>
			
			<div class="xiusProfileRight">
				<div class="xiusMiniProfile">
				<?php 
				if(!empty($this->userprofile))	:
					foreach($this->userprofile[$u->userid] as $up)	:
						if($up['value'] != "") :
							if($up['label']=='Name')
								continue;
				  			echo '<span><b>'.JText::_($up['label']).' :</b> ';
				  			echo JText::_($up['value'])."</span><br />";
						endif; 
					endforeach;
 				endif;
				?>
				</div>
				<div class="xiusStatus">
					<div style="text-align: right">
						<div class="xiusOnline">
							<?php if($cuser->isOnline()): ?>
									<img src="<?php echo JURI::base().'components/com_xius/assets/images/online.png';?>" />
									<?php echo JText::_('Online');?>						
							<?php else	: ?>
									<img src="<?php echo JURI::base().'components/com_xius/assets/images/offline.png';?>" />
									<?php echo JText::_('Offline');?>
							<?php endif; ?>
						</div>
						
						<div class = "xiusFriends">
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/friends.png';?>" />
							<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id );?>"><?php echo JText::sprintf( ($cuser->getFriendCount()) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $cuser->getFriendCount());?></a>
						</div>
						<?php 
							$onlineUser = JFactory::getUser();
							if($onlineUser->id != 0 && $onlineUser->id != $u->userid)	:
								?>
								<div class = "xiusFriends">
									<img src="<?php echo JURI::base().'components/com_xius/assets/images/msg.png';?>" />
									 <a onclick="<?php echo CMessaging::getPopup($u->userid); ?>" href="javascript:void(0);">	            	            
				            			<?php echo JText::_('Message'); ?>
				            		</a>
								</div>
						<?php endif;?>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="clr"></div>	
	</div>
	<?php endforeach;
	JTable::addIncludePath(XIUS_PATH_TABLE);
	 ?>
</div>

