<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

//for replacing tooltip of js by xius
ob_start();
?>
var FieldIds= new Array();
var tooltip = new Array();
var i = 0; 
<?php 
if(!empty($this->availableInfo))
foreach($this->availableInfo as $data):
if($data['info']->pluginType == 'Jsfields'):
?>
 FieldIds[i++] = "<?php echo "field".$data['info']->key ;?>";
 tooltip["<?php echo "field".$data['info']->key ;?>"]  = "<?php echo $data['tooltip']?>";
 <?php endif;
endforeach; ?><?php
		$content = ob_get_contents();
		ob_clean();
        JFactory::getDocument()->addScriptDeclaration($content);?>
<script type="text/javascript"> 
joms.jQuery(document).ready(function($) {
	xiushidediv()
	for (i = 0; i < (FieldIds.length); i++) {
		if(tooltip[FieldIds[i]] !=""){
			joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
			joms.jQuery('.'+FieldIds[i]).children().children().attr('title',tooltip[FieldIds[i]]);
		}
	}
});
</script>
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
								echo $data['label']; 
						?>
						</div>
						<div class="xius_aiInput field<?php echo $data['info']->key?>">
						<?php if(!empty($xiustooltip) && $data['info']->pluginType != 'Jsfields'): 
				 			echo '<span class="jomNameTips" title="'.$xiustooltip.'">'. $data['html'].'</span>';?>
					    <?php else: ?>
							<?php echo $data['html'];?>
						<?php endif;?>
						</div>
						<div class="xius_aiImg">
						<img class="xius_test_addinfo_<?php echo $data['infoid'];?>" src="components/com_xius/assets/images/add.png" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
								alt="<?php echo XiusText::_("XIUS_ADD_TO_SEARCH");?>" title="<?php echo XiusText::_("XIUS_ADD_TO_SEARCH");?>" onClick="xiusAddInfo(<?php echo $data['infoid'];?>);"/>
						</div>
					</div>	
			<?php endforeach; ?>


	<input type="hidden" name="xiusaddinfo" value="" />
</div></div>
<?php 