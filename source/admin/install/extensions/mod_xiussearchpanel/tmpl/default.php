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
if ($params->get('xius_layout','horizontal')=='vertical')
	$document->addStyleSheet($path.'mod_xiussearchpanel_ver.css');
else
	$document->addStyleSheet($path.'mod_xiussearchpanel_hz.css');

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
joms.jQuery(document).ready(function($) {
	for (i = 0; i < (FieldIds.length); i++) {
		if(tooltip[FieldIds[i]] !="")
			joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
	}
});
</script>
	<div class="xiusMod_available" id="xiusMod_available">
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo XiusRoute::_($link,false);?>" method=post>
		<?php 	
			$count=0;
			foreach($displayInfo as $info):
				$count++;
			?> 
				<div class="xiusMod_availablemain">
				
				<div class="xiMod_left">
					<?php
						//echo JHTML::_('tooltip',XiusText::_($xiustooltip), XiusText::_($info['label']), null, XiusText::_($info['label']));
						$xiustooltip = $info['tooltip'];
						echo $info['label']; 
					?>
				</div>
				<div class="xiMod_right field<?php echo $info['info']->key?>">
				<?php if(!empty($xiustooltip) && $info['info']->pluginType != 'Jsfields'): 
				 echo '<span class="jomNameTips" title="'.$xiustooltip.'">'.$info['html'].'</span>';?>
		    <?php else: ?>
				<?php echo $info['html'];?>
			<?php endif;?>
				</div>
			   	</div>	
			<?php 
			endforeach;
			?>
			<input type="hidden" name="fromPanel" value="true" />			
			<div class ="xiusModSearch"><input class="btn" id="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('Search'); ?>" /></div>
		</form>
	</div>
