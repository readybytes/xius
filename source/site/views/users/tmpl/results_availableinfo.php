<script language="javascript" type="text/javascript">
	function addInfo(infoid) {
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		form.subtask.value = 'xiusaddinfo';
		form.submit();
	}
	
</script>


<fieldset><legend> <?php echo JText::_('Available Information');?> </legend>
<div class="xius_available">
<?php 
if(!empty($this->availableInfo))
		foreach($this->availableInfo as $data):
			?> <div class="xius_availablemain">
				<div class="xi_left"><?php echo JText::_($data['label']);?></div>
				<div class="xi_right"><?php echo $data['html'];?>
				<img src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								alt="Add" onClick="addInfo(<?php echo $data['infoid'];?>);"/>
		</div>
				</div>		
		<?php 
		endforeach;
?></div>
</fieldset>

<input type="hidden" name="xiusaddinfo" value="" />