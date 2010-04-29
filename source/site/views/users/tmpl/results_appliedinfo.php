<script language="javascript" type="text/javascript">
	function deleteInfo(infoid,valueBoxId)
	{
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		form.subtask.value = 'xiusdelinfo';
		form.submit();
	}
</script>
<?php 
if(!empty($this->appliedInfo)) : ?>
	<fieldset><legend>Applied Info</legend>
	<?php $data = $this->appliedInfo;
	$count = 0;
	foreach($this->appliedInfo as $a) :
		$count++; ?>
		<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo serialize($a['value']);?>' />
		<?php 
		echo '<div class="applied"><div class="left"><div><b>'.$a['label']."</b></div><div>".$a['value'];
		echo '</div></div><div class="right"><img src="administrator/components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="deleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/></div></div>';
	endforeach;

?>
<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
</fieldset>
<?php endif; ?>