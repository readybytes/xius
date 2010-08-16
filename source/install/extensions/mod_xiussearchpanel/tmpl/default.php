<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

$document =& JFactory::getDocument();
if ($params->get('xius_layout','horizontal')=='vertical')
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_ver.css');
else
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_hz.css');

?>
	<div class="xiusMod_available" id="xiusMod_available">
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo JRoute::_($link,false);?>" method=post>
		<?php 	
			$count=0;
			foreach($displayHtml as $data):
				$count++;
				if(count($range)>0){
					 if( $range['start']!=0 && $count < $range['start'])
						continue;
					 if($range['end']!=0 && $count > $range['end']) 
						break;
				}
			?> 
				<div class="xiusMod_availablemain">
				
				<div class="xiMod_left">
					<?php
						//echo JHTML::_('tooltip',JText::_($xiustooltip), JText::_($data['label']), null, JText::_($data['label']));
						$xiustooltip = $data['tooltip'];
						if(!empty($xiustooltip)) :
						echo '<span title="'.JText::_($xiustooltip).'">'.JText::_($data['label']).'</span>';						
						else :
							echo JText::_($data['label']); 
						endif;
					?>
				</div>
				<div class="xiMod_right"><?php echo $data['html'];?></div>
			   	</div>	
			<?php 
			endforeach;
			?>
			<input type="hidden" name="subtask" value="xiussearch" />			
			<div class ="xiusModSearch"><input id="xiusMod<?php echo $module->id;?>Search" type="submit" value="Search" /></div>
		</form>
	</div>