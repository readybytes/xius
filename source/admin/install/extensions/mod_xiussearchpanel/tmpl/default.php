<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Module
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$document = JFactory::getDocument();
$path     = JURI::base().DS.'modules'.DS.'mod_xiussearchpanel'.DS.'css'.DS;
$document->addStyleSheet($path.'mod_xiussearchpanel.css');

//for replacing tooltip of js by xius
$script = "
var FieldIds= new Array();
var tooltip = new Array();
var i = 0; 
";
foreach($displayInfo as $data):
if($data['info']->pluginType == 'Jsfields'):
	$script .=  " FieldIds[i++] = 'field".$data['info']->key."';" 
               ." tooltip['field".$data['info']->key."']  = " 
               . "'{$data['tooltip']}'".";";
  endif;
endforeach;
JFactory::getDocument()->addScriptDeclaration($script);?>
<script type="text/javascript"> 
window.joms_queue || (joms_queue = []);
joms_queue.push(function() {
	joms.jQuery(document).ready(function($) {
		for (i = 0; i < (FieldIds.length); i++) {
			if(tooltip[FieldIds[i]] !="")
				joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
		}
	})
});
</script>
<?php 
	if ($params->get('xius_layout','horizontal')!='vertical')
	{
?>
	<div>
		<div class="container-fluid joms-page xiusMod_available" id="xiusMod_available">
			<form class="xius-search-panel" id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo XiusRoute::_($link,false);?>" method=post>
				<div class="row-fluid">
					<h3><span class="xius-margin">Search</span></h3>
					<hr>
				</div>
				<?php 	
					$count=0;
					foreach($displayInfo as $info):
						$count++;
				?>
				<div class="row-fluid xius-margin">
					<div class="span4">
						<?php
							//echo JHTML::_('tooltip',XiusText::_($xiustooltip), XiusText::_($info['label']), null, XiusText::_($info['label']));
							$xiustooltip = $info['tooltip'];
							echo $info['label']; 
						?>
					</div>
					<div class="span8 field<?php echo $info['info']->key?>">
						<?php if(!empty($xiustooltip) && $info['info']->pluginType != 'Jsfields'): 
				 				echo '<span class="jomNameTips" title="'.$xiustooltip.'">'.$info['html'].'</span>';?>
		    			<?php else:
								echo $info['html'];?>
						<?php endif;?>
					</div>
				</div>
				<?php 
					endforeach;
				?>
				<input type="hidden" name="fromPanel" value="true" />
				<div class="row-fluid xius-margin">
					<div class="span4">	</div>			
					<div class ="span8"><input class="joms-button--primary joms-button--full-small" id="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('Search'); ?>" /></div>
				</div>
			</form>
		</div>
	</div>
	<?php }
	else{
		?>
		<div class="xiusMod_available" id="xiusMod_available">
			<form class="xius-search-panel" id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo XiusRoute::_($link,false);?>" method=post>
				<?php 	
					$count=0;
					foreach($displayInfo as $info):
						$count++;
				?>
				<div class="row-fluid xiusMod_availablemain">
					<div>
						<?php
							//echo JHTML::_('tooltip',XiusText::_($xiustooltip), XiusText::_($info['label']), null, XiusText::_($info['label']));
							$xiustooltip = $info['tooltip'];
							echo $info['label']; 
						?>
					</div>
					<div class="field<?php echo $info['info']->key?>">
						<?php if(!empty($xiustooltip) && $info['info']->pluginType != 'Jsfields'): 
				 				echo '<span class="jomNameTips" title="'.$xiustooltip.'">'.$info['html'].'</span>';?>
		    			<?php else:
								echo $info['html'];?>
						<?php endif;?>
					</div>
				</div>
				<?php 
					endforeach;
				?>
				<input type="hidden" name="fromPanel" value="true" />
				<div class="row-fluid text-center">
					<input class="joms-button--primary joms-button--full-small" id="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('Search'); ?>" />
				</div>
			</form>
		</div>
	<?php }
	?>
<?php 	
