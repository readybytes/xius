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
		ob_end_clean();
        JFactory::getDocument()->addScriptDeclaration($content);?>
<script type="text/javascript"> 
window.joms_queue || (window.joms_queue = []);
window.joms_queue.push(function( $ ) {
	$(document).ready( function($){
		for (i = 0; i < (FieldIds.length); i++) {
			if(tooltip[FieldIds[i]] !=""){
				joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
				joms.jQuery('.'+FieldIds[i]).children().children().attr('title',tooltip[FieldIds[i]]);
			}
		}	

		$("div[id^=accordion-body-id-]").on('shown', function () {
			$(this).parent().find(".icon-chevron-down").removeClass("icon-chevron-down").addClass("icon-chevron-right");
		});

		$("div[id^=accordion-body-id-]").on('hidden', function () {
			$(this).parent().find(".icon-chevron-right").removeClass("icon-chevron-right").addClass("icon-chevron-down");
		});   
	});
});

</script>

<div id="xiusFlForm">
	<div class="row-fluid text-center">
		<button type="submit" class="joms-button--primary joms-button--full-small" name="xiussearch" id="xiussearch"><?php echo XiusText::_("APPLY_ALL");?> <i class="icon-chevron-right"></i></button>	
	</div>
	<?php
		if(!empty($this->availableInfo))
			foreach($this->availableInfo as $data):
	?> 
			<div id="xius_Info_Ref<?php echo $data['infoid']; ?>">
				<div class="xiusFlLabel row-fluid joms-form__group xius-padding">
					<div class="span12">
						<div class="accordion" id="accordion-id-<?php echo $data['info']->key;?>">
							<div class="accordion-group">
								<div class="accordion-heading xius-font-color">
									
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-id-<?php echo $data['info']->key;?>" href="#accordion-body-id-<?php echo $data['info']->key;?>">
											<i class="icon-chevron-right"></i>
											<strong><?php
												//echo JHTML::_('tooltip',XiusText::_($xiustooltip), XiusText::_($data['label']), null, XiusText::_($data['label']));
														$xiustooltip = $data['tooltip'];
														echo $data['label']; 
													?>
											</strong>
										</a>
								</div>
								<div class="accordion-body collapse in" id="accordion-body-id-<?php echo $data['info']->key;?>">
									<div class="accordion-inner field joms-form__group row-fluid">
										<div class="span10">
											<?php if(!empty($xiustooltip) && $data['info']->pluginType != 'Jsfields'): 
									 				echo '<span class="jomNameTips" title="'.$xiustooltip.'">'. $data['html'].'</span>';?>
									    	<?php else: ?>
													<?php echo $data['html'];?>
											<?php endif;?>
										</div>
										<div class="span2 xius-add-filter xius-pointer xius_test_addinfo_<?php echo $data['infoid'];?>" id="<?php echo $data['infoid'];?>" name="<?php echo $data['infoid'];?>"  
														 title="<?php echo XiusText::_("XIUS_ADD_TO_SEARCH");?>" onClick="xiusAddInfo(<?php echo $data['infoid'];?>);">
<!--												<i class="icon-plus xius-icon-bg small xius-padding pull-right"></i>--><small>Add</small>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr>
	<?php endforeach; ?>
			<div class="row-fluid text-center">
				<button type="submit" class="joms-button--primary joms-button--full-small" name="xiussearch" id="xiussearch">Apply All <i class="icon-chevron-right"></i></button>	
			</div>
			<hr>
	<input type="hidden" name="xiusaddinfo" value="" />
</div>
<?php 
