<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_ul">
<div class="xiusTotal">
<span class="xiusTotalText" id="total_<?php echo $this->total;?>">
	<?php echo sprintf(JText::_('About :  %s results found'),$this->total);?>
</span>
</div>
<?php
	 foreach($this->users as $u)	:
	 		JTable::addIncludePath( JPATH_ROOT .DS.'administrator'.DS.'components'.DS.'com_community' . DS . 'tables' );
		  	$cuser = CFactory::getUser($u->userid); ?>	
		  	<div class="xiusMp">	
				<div class="xiusHeader">
				<?php echo JText::_($cuser->name);?> 
				<?php echo JText::_($cuser->getStatus()) ;?>
					<div class="xiusMpOptions">	
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>" >
					<img src="<?php echo JURI::base().'components/com_xius/assets/images/viewprofile.png';?>" title="View User Profile" />
					</a>			
					<?php 
						$onlineUser = JFactory::getUser();
						if($onlineUser->id != 0 && $onlineUser->id != $u->userid)	:
					?>
							<a onclick="<?php echo CMessaging::getPopup($u->userid); ?>" href="javascript:void(0);">
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/msg.png';?>" title="Write Message" />
							</a>
					<?php 
						endif;
					?>
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=friends&userid=' . $cuser->id );?>">
					<img src="<?php echo JURI::base().'components/com_xius/assets/images/friends.png';?>" title="<?php echo JText::sprintf( ($cuser->getFriendCount()) ? 'CC FRIENDS COUNT MANY' : 'CC FRIENDS COUNT' , $cuser->getFriendCount());?>" />
					</a>
					<?php
						 if($cuser->isOnline()): ?>
						 	<img  src="<?php echo JURI::base().'components/com_xius/assets/images/online.png';?>" title="Online" />
					<?php
						 else	: 
					?>
							<img src="<?php echo JURI::base().'components/com_xius/assets/images/offline.png';?>" title="Offline" />
					<?php 
						endif; 
					?>
					</div>
			</div>
			<div class="xiusMpMiddle">
 				<div class="xiusMpAvatar">
 					<img id="avatar_<?php echo $cuser->id;?>" src="<?php echo $cuser->getThumbAvatar();?>" onclick='location.href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$cuser->id,false);?>"'/>
				</div>
			
			<div class="xiusMpData">
					<?php 
					if(!empty($this->userprofile))	:
						foreach($this->userprofile[$u->userid] as $up)	:
							if($up['value'] != "") :
								if($up['label']=='Name')
									continue;
					  			?>
					  			<div class="xiusMpInfo">
					  			<div class="xiusMplabel"><?php echo JText::_($up['label']); ?></div>
					  			<div class="xiusMpValue"><?php echo JText::_($up['value']); ?></div>
					  			</div>
					  			<?php 
							endif; 
						endforeach;
	 				endif;
					?>			
			</div>
			</div>
				
						

		
	
		   </div>
	<?php endforeach;
		JTable::addIncludePath(XIUS_PATH_TABLE);
	?>
</div>

