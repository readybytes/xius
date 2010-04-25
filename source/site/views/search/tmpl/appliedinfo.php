<script language="javascript" type="text/javascript">
	function deleteInfo(infoid) {
		var form = document.basicSearchForm;
		form.xiusdelinfo.value = infoid.id;
		form.submit();
	}
	
</script>

<div class="applied">
	<div class="head">I Am Applied Info.php
	</div>
<?php 
if(!empty($this->appliedInfo)){
	
	$data = $this->appliedInfo;
	foreach($this->appliedInfo as $a){
		echo $a['label']." ".$a['value'];
		echo '<img src="administrator/components/com_xius/assets/images/minus.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'" height="16" width="16" 
								alt="Remove" onClick="deleteInfo(this);"/>';
	}
}
?>
<input type="hidden" name="xiusdelinfo" value="" />
</div>