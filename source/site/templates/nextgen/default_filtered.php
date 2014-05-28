<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!empty($this->appliedInfo)) : ?>
<div id="xiusFiltered">
<div id="xiusFdHead">
	<?php
	echo XiusText::_('FILTERED_BY');
	?>
	<div id="xiusClearAll" title="<?php echo XiusText::_('XIUS_CLEAR_ALL_APPLIED_INFO');?>"  onclick="xiusAddSubTask('resetfilter')">
	<img src="<?php echo JURI::base().'components/com_xius/assets/images/clear_all.png';?>" title="<?php echo XiusText::_('XIUS_CLEAR_ALL_APPLIED_INFO');?>" onclick="xiusAddSubTask('resetfilter')" />
	<?php
	//echo XiusText::_('CLEAR ALL');
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
					?><span class="xiusFdClear" id="<?php echo $a['infoid']; ?>" onClick="xiusDeleteInfo(this,'delinfovalue_<?php echo $a['infoid'].$count; ?>');"><?php echo XiusText::_('CLEAR');?></span></div>
					<div class="xiusFdValue">
					<?php 
					if(is_array($a['formatvalue']))	:	
						foreach($a['formatvalue'] as $a_values) 
							echo JText::_($a_values);
					else	:
				echo JText::_($a['formatvalue']);
			endif;
			
			//echo '<img class="xius_test_remove_'.$a['formatvalue'].'"  src="components/com_xius/assets/images/delete.pg" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
			//						alt="X" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/>';		
			?>
			</div>
		</div>	
		<?php endforeach; 

		echo $this->loadTemplate('joinhtml');

?>


<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
</div>
<?php 
endif;
?>

