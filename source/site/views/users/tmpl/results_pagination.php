<div class="pagination">
    <div>
    	<div style="float:left; width:50%;"> 
		   <?php echo $this->pagination->getPagesLinks();
		   ?>
		</div>
		<div style="float:right; width:25%;margin-top:12px;margin-left:10px;">
			<?php echo $this->pagination->getLimitBox();?>		
		</div><br />
		<?php /*XITODO : dont't give static path for back , it can be search or list */ ?>
		<a href="index.php?option=com_xius&view=users">
		<img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/back.png';?>" title="Go Back To Search Panel"/></a>
		<br /><br />
		
	</div>
</div>