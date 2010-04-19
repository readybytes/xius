<?php 
?>
<div class="ul1">
	<div class="head">I Am UserLIsting.php</div>
	
	
		<?php foreach($this->items as $li)
		{
		$cuser = CFactory::getUser($li->userid);
		?>
		<div class="main"><div class="left">
		<img src="<?php echo $cuser->getAvatar();?>" />
		</div>
	
		<div class="right">	
		<?php echo $li->userid;?><hr />
		</div></div>
	 <?php }?>
	 
</div>
