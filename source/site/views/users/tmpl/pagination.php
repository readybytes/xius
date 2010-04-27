<div class="pagination">
    <div>
    	<div style="float:left; width:50%;"> 
		   <?php echo $this->pagination->getPagesLinks();
		   ?>
		</div>
		<div style="float:right; width:25%;margin-top:12px;margin-left:10px;">
			<?php echo $this->pagination->getLimitBox();?>		
		</div><br />
		<a href="index.php?option=com_xius&view=search&task=showsearchpanel"> <<< Back</a>
		<br /><br />
		
	</div>
</div>