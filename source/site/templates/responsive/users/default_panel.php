<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$this->loadAssets('css', 'panel.css');
$document = JFactory::getDocument();
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
//for replacing tooltip of js by xius
ob_start();
?>
var FieldIds= new Array();
var tooltip = new Array();
var i = 0; 
<?php 
foreach($this->infohtml as $data):
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
window.joms_queue || (joms_queue = []);
joms_queue.push(function() {
	joms.jQuery(document).ready(function($) {
		for (i = 0; i < (FieldIds.length); i++) {
			if(tooltip[FieldIds[i]] !=""){
				joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
			    joms.jQuery('.'+FieldIds[i]).children().children().attr('title',tooltip[FieldIds[i]]);
			}
		}
	})
});
	
</script> 
<?php 
?>

<div class="container-fluid joms-page" id="xius_sp">
	<form action="<?php echo XiusRoute::_($this->submitUrl);?>" method="post" name="userForm" id="userForm">
		<div class="row-fluid">
			<h3><span class="xius-font-color xius-margin"><?php echo XiusText::_('SEARCH');?></span></h3>
			<hr>
		</div>
		<?php
		$count = 0;
		$i  = 0;

		if(empty($this->infohtml)):
		?>
			<!-- <div class="xiusNoInfo"> -->
			<h3>
			<?php echo XiusText::_('ALL_SEARCHABLE_INFORMATION_HAS_BEEN_DISABLED_BY_ADMINISTRATOR');?>
			</h3>
			<!-- </div> -->
		<?php
		else:
		foreach($this->infohtml as $data):
			?>
			<div class="row-fluid xius-font-color xius-margin">
				<div class="span3">
					<small><strong><?php
					$xiustooltip = $data['tooltip'];
					echo $data['label'];
					?></strong></small>
				</div>
				<div class="span9 field<?php echo $data['info']->key?>">
					<?php if(!empty($xiustooltip) && $data['info']->pluginType != 'Jsfields'): 
						 echo '<span class="jomNameTips" title="'.$xiustooltip.'">'.$data['html'].'</span>';?>
				    <?php else: ?>
						<?php echo $data['html'];?>
					<?php endif;?>
				</div>
			</div>
		<?php
		endforeach;
		?>
		<div class="row-fluid" style="display:none;">
			<?php echo $this->loadTemplate('joinhtml');	?>
		</div>
		
		<div class="row-fluid xius-margin">
			<div class="span3"></div>
			<div class="span9 ">
				<input type="submit" id="xiussearch" name="xiussearch" class="joms-button--primary joms-button--full-small" value="<?php echo XiusText::_("SEARCH_BUTTON");?>" />
			</div>
		</div>
		<?php
		endif;
		?>
		<input type="hidden" name="fromPanel" value="true" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
<?php 