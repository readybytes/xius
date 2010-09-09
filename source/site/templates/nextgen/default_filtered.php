<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!empty($this->appliedInfo)) : ?>
<div id="xiusFdHead">
	<?php
	echo JText::_('FILTERED BY');
	?>
	<div id="xiusClearAll" title="<?php echo JText::_('XIUS CLEAR ALL APPLIED INFO');?>"  onclick="xiusAddSubTask('resetfilter')">
	<?php
	echo XiusText::_('CLEAR ALL');
	?> 
	</div>
</div>
<?php 
	$count = 0;
	foreach($this->appliedInfo as $a) :
		$count++; ?>
		<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo XiusHelperUsers::getSerializedData($a['value']);?>' />
		<div class="xiusFdData">
			<div class="xiusFdLabel">
				<?php 
					echo JText::_($a['label']);
					if(is_array($a['formatvalue']))	:	
						foreach($a['formatvalue'] as $a_values) 
							echo $a_values;
					else	:?>
			<span class="xiusFdClear" id="<?php echo $a['infoid']; ?>" onClick="xiusDeleteInfo(this,'delinfovalue_<?php echo $a['infoid'].$count; ?>');">Clear</span></div>
			<div class="xiusFdValue">
			<?php
				echo $a['formatvalue'];
			endif;
			
			echo '<img class="xius_test_remove_'.$a['formatvalue'].'"  src="components/com_xius/assets/images/delete.pg" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
									alt="X" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/>';		
			?>
			</div>
		</div>	
		<?php endforeach; ?>
<div class="xijoin">
<?php 
$orSelected = '';
$andSelected = '';
if($this->join == 'AND'):
	$andSelected = ' selected=true ';
elseif($this->join == 'OR') :
	$orSelected = ' selected=true ';
endif;
	
$joinhtml = '<select id="xiusjoin" name="xiusjoin" onchange="xiusApplyJoin(\'join\');" >';
$joinhtml .= '<option value="AND" '.$andSelected.'>'.XiusText::_('MATCH ALL').'</option>';
$joinhtml .= '<option value="OR" '.$orSelected.'>'.XiusText::_('MATCH ANY').'</option>';
$joinhtml .= '</select>';
echo '<b>'.XiusText::_('XIUS JOIN WITH').'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
echo $joinhtml;	
?>
</div>


<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
<?php 
endif;
?>
