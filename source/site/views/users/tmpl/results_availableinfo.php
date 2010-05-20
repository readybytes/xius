<script language="javascript" type="text/javascript">
	function addInfo(infoid) {
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		form.subtask.value = 'xiusaddinfo';
		form.submit();
	}
	
</script>
<div class="xius_ai">
<div class="xius_aiHead">
<?php
echo JText::_('Available Information');
?>
</div>
<?php 
if(!empty($this->availableInfo))
		foreach($this->availableInfo as $data):
			?> 
			<div class="xius_aiMain">
				<div class="xius_aiLabel">
				<?php echo JText::_($data['label']);?>
				</div>
				<div class="xius_aiInput">
				<?php echo $data['html'];?>
				</div>
				<div class="xius_aiImg">
				<img class="xius_test_addinfo_<?php echo $data['infoid'];?>" src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
						alt="Add" title="Search" onClick="addInfo(<?php echo $data['infoid'];?>);"/>
				</div>
			</div>	
		<?php 
		endforeach;
?>


<input type="hidden" name="xiusaddinfo" value="" />
</div>