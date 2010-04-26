<script language="javascript" type="text/javascript">
	function deleteInfo(infoid) {
		var form = document.basicSearchForm;
		form.xiusdelinfo.value = infoid.id;
		form.submit();
	}
	
</script>

	<fieldset><legend>Applied Info</legend>
	<?php 
if(!empty($this->appliedInfo)){
	
	$data = $this->appliedInfo;
	foreach($this->appliedInfo as $a){
		echo '<div class="applied"><div class="left"><div><b>'.$a['label']."</b></div><div>".$a['value'];
		echo '</div></div><div class="right"><img src="administrator/components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="deleteInfo(this);"/></div></div>';
		
		
	}
}
?>
<input type="hidden" name="xiusdelinfo" value="" />
</fieldset>