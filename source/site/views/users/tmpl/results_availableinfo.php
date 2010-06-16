<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/  
?>
<script type="text/javascript">
	function hideshowdiv()
	{
		if(document.getElementById("xiushide").className=="xiusSliderHide")
		{
			showdiv();
		}
		else
		{
			hidediv();	
		}
	}

	function hidediv()
	{
		document.getElementById("xiushide").setAttribute("class", "xiusSliderHide");
		document.getElementById("xiusSliderImg").setAttribute("class", "xiusSlideImgDown");	
	}

	function showdiv()
	{
		document.getElementById("xiushide").setAttribute("class", "xiusSlider");
		document.getElementById("xiusSliderImg").setAttribute("class", "xiusSlideImgUp");
	}

</script>

<div class="xius_ai">
	<div class="xius_aiHead">
		<a href="javascript:hideshowdiv();"> <?php echo JText::_('Available Information'); ?></a>
		<div id="xiusSliderImg" class="<?php if($this->xiusSlideShow=='none'){ echo 'xiusSlideImgUp'; } else{ echo 'xiusSlideImgDown';} ?>">&nbsp;</div>
	</div>
<div id="xiushide" class="<?php if($this->xiusSlideShow=='none'){ echo 'xiusSliderHide'; } else{ echo 'xiusSlider'; } ?>">
	<?php
			
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
</div></div>