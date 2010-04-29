<script language="javascript" type="text/javascript">
	function deleteInfo(infoid) {
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.subtask.value = 'xiusdelinfo';
		form.submit();
	}
	
</script>
<?php 
if(!empty($this->appliedInfo)) : ?>
	<fieldset><legend>Applied Info</legend>
	<?php $data = $this->appliedInfo;
	foreach($this->appliedInfo as $a) :
		echo '<div class="applied"><div class="left"><div><b>'.$a['label']."</b></div><div>".$a['value'];
		echo '</div></div><div class="right"><img src="administrator/components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="deleteInfo(this);"/></div></div>';
		
		
	endforeach;

?>
<input type="hidden" name="xiusdelinfo" value="" />
</fieldset>
<?php endif; ?>