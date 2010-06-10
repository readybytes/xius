<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/  
?>
<div class="xius_ai">
	<div class="xius_aiHead">
		<?php $slide = new XiusHelperSlide(); ?>
		<?php echo $slide->button(JText::_('Available Information'), 'xius_avail_info_toggle_1', 'xius_avail_info_slide_1'); ?>
	</div>

	<?php  echo $slide->startSlider('xius_avail_info_slide_1', 'class="greyBox"');
		   if(!empty($this->availableInfo))
			foreach($this->availableInfo as $data):
				?> 
					<div class="xius_aiMain" id="xius_Info_Ref<?php echo $data['infoid']; ?>">
						<div class="xius_aiLabel">
						<?php echo JHTML::_('tooltip',JText::_($data['tooltip']), JText::_($data['label']), null, JText::_($data['label'])); ?>
						</div>
						<div class="xius_aiInput">
						<?php echo $data['html'];?>
						</div>
						<div class="xius_aiImg">
						<img class="xius_test_addinfo_<?php echo $data['infoid'];?>" src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								alt="Add To Search" title="Add To Search" onClick="xiusAddInfo(<?php echo $data['infoid'];?>);"/>
						</div>
					</div>	
			<?php endforeach; ?>


	<input type="hidden" name="xiusaddinfo" value="" />
	<?php  echo $slide->endSlider(); ?>
	<?php  XiusHelperSlide::addScript(); ?>
</div>