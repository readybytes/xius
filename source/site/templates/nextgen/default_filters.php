<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/  
?>
	<div id="xiusFlHead">
	<?php echo XiusText::_('FILTER_BY'); ?>
	</div>
	<div id="xiusFlForm">
		<?php
			if(!empty($this->availableInfo))
				foreach($this->availableInfo as $data):
		?> 
					<div class="xiusFlData" id="xius_Info_Ref<?php echo $data['infoid']; ?>">
						<div class="xiusFlLabel">
						<div class="xiusFlImg">
						<div class="xius_test_addinfo_<?php echo $data['infoid'];?>" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								 title="<?php echo XiusText::_("XIUS_ADD_TO_SEARCH");?>" onClick="xiusAddInfo(<?php echo $data['infoid'];?>);">
						ADD
						</div>
						</div>
						<?php
						//echo JHTML::_('tooltip',XiusText::_($xiustooltip), XiusText::_($data['label']), null, XiusText::_($data['label']));
							$xiustooltip = $data['tooltip'];
							if(!empty($xiustooltip)) :
								echo '<span title="'.$xiustooltip.'">'.$data['label'].'</span>';
							else :
								echo $data['label']; 
							endif;
						?>
						</div>
						<div class="xiusFlInput">
						<?php echo $data['html'];?>
						</div>
					</div>	
			<?php endforeach; ?>


	<input type="hidden" name="xiusaddinfo" value="" />
</div><?php 
