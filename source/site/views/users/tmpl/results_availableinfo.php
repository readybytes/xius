<script language="javascript" type="text/javascript">
	function addInfo(infoid) {
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		form.subtask.value = 'xiusaddinfo';
		form.submit();
	}
	
</script>

<div class="xius_ablemain">
<fieldset><legend>Available Info</legend>
<?php 
if(!empty($this->availableInfo))
		foreach($this->availableInfo as $data):
			?> <div class="xius_able">
				<span><?php echo $data['html'];?>
				<?php echo $data['label'];?>
				<img src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								alt="Add" onClick="addInfo(<?php echo $data['infoid'];?>);"/>
		</span>
				</div>		
		<?php 
		endforeach;
?>
</fieldset>
</div>
<input type="hidden" name="xiusaddinfo" value="" />