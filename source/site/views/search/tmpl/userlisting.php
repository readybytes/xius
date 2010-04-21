<?php 
?>
<div class="ul1">
	<div class="head">I Am UserLIsting.php</div>
	
	
		<?php foreach($this->users as $u)
		{
		$cuser = CFactory::getUser($u->userid);
		?>
		<div class="main"><div class="left">
		<img src="<?php echo $cuser->getAvatar();?>" />
		</div>
	
		<div class="right">	
		<?php echo $u->userid;
		if(!empty($this->userprofile)){
			//print_r(var_export($this->userprofile[$u->userid]));
			foreach($this->userprofile[$u->userid] as $up){
				if($up['value'] != ""){
				  echo '<div style="float:left; top-margin:0px;"><div class="label">'.$up['label']."</div>";
				  echo '<div class="value">'.$up['value']."</div></div><br />";
				}
			}
		}
		?>
		</div></div>
	 <?php }?>
	 
</div>
