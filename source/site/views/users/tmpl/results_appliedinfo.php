<script language="javascript" type="text/javascript">
	function deleteInfo(infoid,valueBoxId)
	{
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		form.subtask.value = 'xiusdelinfo';
		form.submit();
	}

	function applyJoin(subtask) 
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}
</script>

<?php 
if(!empty($this->appliedInfo)) : ?>
<div class="xiusAppliedinfo">
	<!--<fieldset><legend><?php echo JText::_('Applied Information');?></legend>-->
	 <h3 style="width:100%; border-bottom:1px solid #275788; margin:5px;">Applied Information</h3>

<?php $data = $this->appliedInfo;
	$count = 0;
	foreach($this->appliedInfo as $a) :
		$count++; ?>
		<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo serialize($a['value']);?>' />
		<?php 
		echo '<div class="applied"><div class="left"><div><b>'.JText::_($a['label']).'</b>';
		if(is_array($a['formatvalue']))	:	
			foreach($a['formatvalue'] as $a_values) 
				echo '<div>'.$a_values.'</div>';
		else	:
			echo '<div>'.$a['formatvalue'].'</div>';
		endif;
		
		echo '</div></div><div class="right"><img src="components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="deleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/></div></div>';		
	endforeach;?>
<div class="applied">
<?php 
$orSelected = '';
$andSelected = '';
if($this->join == 'AND')
	$andSelected = ' selected=true ';
else if($this->join == 'OR')
	$orSelected = ' selected=true ';
	
$joinhtml = '<select id="xiusjoin" name="xiusjoin" onchange="applyJoin(\'xiusjoin\');" >';
$joinhtml .= '<option value="AND" '.$andSelected.'>'.JText::_('MATCH ALL').'</option>';
$joinhtml .= '<option value="OR" '.$orSelected.'>'.JText::_('MATCH ANY').'</option>';
$joinhtml .= '</select>';
echo '<b>'.JText::_('Join With').'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
echo $joinhtml;	
?>
</div>
<?php 
endif;
?>

<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
<!--</fieldset> -->
</div>
