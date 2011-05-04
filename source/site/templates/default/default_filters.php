<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/  
?>

<div class="<?php if($this->xiusSlideShow=='none'){ echo 'xius_ai'; } else{ echo 'xius_ai_full';} ?>" id="xius_ai";>
	<div class="xius_aiHead">
		<div onclick="javascript:xiushideshowdiv();" style="cursor: pointer;"> <?php echo XiusText::_('AVAILABLE_INFORMATION'); ?>
		<div id="xiusSliderImg" class="<?php if(!$this->xiusSlideShow=='none'){ echo 'xiusSlideImgUp'; } else{ echo 'xiusSlideImgDown';} ?>">&nbsp;</div>
	</div></div>
<div id="xiushide" class="<?php if($this->xiusSlideShow=='none'){ echo 'xiusSliderHide'; } else{ echo 'xiusSlider'; } ?>">
	<?php
			
		   if(!empty($this->availableInfo))
			foreach($this->availableInfo as $data):
				?> 
					<div class="xius_aiMain" id="xius_Info_Ref<?php echo $data['infoid']; ?>">
						<div class="xius_aiLabel">
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
						<div class="xius_aiInput">
						<?php echo $data['html'];?>
						</div>
						<div class="xius_aiImg">
						<img class="xius_test_addinfo_<?php echo $data['infoid'];?>" src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								alt="<?php echo XiusText::_("XIUS_ADD_TO_SEARCH");?>" title="<?php echo XiusText::_("XIUS ADD TO SEARCH");?>" onClick="xiusAddInfo(<?php echo $data['infoid'];?>);"/>
						</div>
					</div>	
			<?php endforeach; ?>


	<input type="hidden" name="xiusaddinfo" value="" />
</div></div>
<?php 