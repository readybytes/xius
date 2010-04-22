<?php 
?>
<div class="ul1">
	<?php foreach($this->users as $u)
		{
			$cuser = CFactory::getUser($u->userid);
			?>
			<div class="bdy"><div class="head">
			<?php //echo $u->userid;
				if(!empty($this->userprofile)){
					//print_r(var_export($this->userprofile[$u->userid]));
					foreach($this->userprofile[$u->userid] as $up){
		
						if($up['value'] != ""){
						  if($up['label']=='Username'){
						 //echo ucwords($up['value'])."'s Profile";
						  }
						}
					}
				}
			
			?>
			</div>
			<div class="main">
			<div class="left"><img src="<?php echo $cuser->getThumbAvatar();?>" /></div>
			<div class="right"><ul>	
			<?php //echo $u->userid;
			if(!empty($this->userprofile)){
				//print_r(var_export($this->userprofile[$u->userid]));
				foreach($this->userprofile[$u->userid] as $up){
					if($up['value'] != ""){
						if($up['label']=='Username'){
						echo "<h3>".$up['value']."</h3>";
						continue;
						}
					  echo '<li>'.$up['label'].' : ';
					  echo $up['value']."</li>";
					}
				}
	 		}
		?></ul>
		</div><div class="sidebar"><?php if(!$cuser->isOnline())
				echo '<ul><li class="on">online</li></ul>';
			else
				echo '<ul><li class="off">Offline</li></ul>';?></div></div></div>
	 <?php }?>
	 
</div>
