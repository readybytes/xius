<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!empty($this->appliedInfo)) : ?>
<div class="xiusAppliedinfo">
<div class="xius_apiHead">
	<?php
	echo JText::_('Applied Information');
	?>
	<img src="components/com_xius/assets/images/clear_all.png" title="Clear All Applied Info" onclick="xiusAddSubTask('xiusresetfilter')" />
</div>
<?php 
	$count = 0;
	foreach($this->appliedInfo as $a) :
		$count++; ?>
		<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo XiusHelperUsers::getSerializedData($a['value']);?>' />
		<?php 
		echo '<div class="applied"><div class="left"><div><b>'.JText::_($a['label']).'</b>';
		if(is_array($a['formatvalue']))	:	
			foreach($a['formatvalue'] as $a_values) 
				echo '<div>'.$a_values.'</div>';
		else	:
			echo '<div>'.$a['formatvalue'].'</div>';
		endif;
		
		echo '</div></div><div class="right"><img class="xius_test_remove_'.$a['formatvalue'].'"  src="components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/></div></div>';		
	endforeach;?>
<div class="xijoin">
<?php 
$orSelected = '';
$andSelected = '';
if($this->join == 'AND'):
	$andSelected = ' selected=true ';
elseif($this->join == 'OR') :
	$orSelected = ' selected=true ';
endif;
	
$joinhtml = '<select id="xiusjoin" name="xiusjoin" onchange="xiusApplyJoin(\'xiusjoin\');" >';
$joinhtml .= '<option value="AND" '.$andSelected.'>'.JText::_('MATCH ALL').'</option>';
$joinhtml .= '<option value="OR" '.$orSelected.'>'.JText::_('MATCH ANY').'</option>';
$joinhtml .= '</select>';
echo '<b>'.JText::_('Join With').'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
echo $joinhtml;	
?>
</div>


<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
</div>
<?php 
endif;
?>
