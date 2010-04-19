<div class="pagination">
    <div>
		<div style="float:left; width:25%;margin-top:22px;margin-left:20px;">
			User Per Page : <?php echo $this->pagination->getLimitBox();?>		
		</div>
		<div style="float:right; width:70%;"> 
		   <?php echo $this->pagination->getPagesLinks();
		   ?>
		</div>
	</div>
</div>