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
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo XiusRoute::_($link,false);?>" method=post>
		<?php 	
			$count=0;
			foreach($displayHtml as $data):
				$count++;
			?> 
				<div class="xiusMod_availablemain">
				
				<div class="xiMod_left">
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
				<div class="xiMod_right"><?php echo $data['html'];?></div>
			   	</div>	
			<?php 
			endforeach;
			?>
			<input type="hidden" name="fromPanel" value="true" />			
			<div class ="xiusModSearch"><input id="xiusMod<?php echo $module->id;?>Search" type="submit" value="Search" /></div>
		</form>
	</div>