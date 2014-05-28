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
		ob_clean();
        JFactory::getDocument()->addScriptDeclaration($content);?>
<script type="text/javascript"> 
joms.jQuery(document).ready(function($) {
	for (i = 0; i < (FieldIds.length); i++) {
		if(tooltip[FieldIds[i]] !=""){
			joms.jQuery('.'+FieldIds[i]).children().attr('title',tooltip[FieldIds[i]]);
		    joms.jQuery('.'+FieldIds[i]).children().children().attr('title',tooltip[FieldIds[i]]);
		}
	}
});
</script> 
<?php 
?>
<div class="xius_sp" id="xiusSp">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" method="post" name="userForm" id="userForm">

<div id="spHead">
<?php echo XiusText::_('SEARCH');?>
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
			<div class="xiusSpMain">
			<div class="xiusSpLabel">
			<?php
			//echo JHTML::_('tooltip',XiusText::_($xiustool), XiusText::_($data['label']), null, XiusText::_($data['label']));
			$xiustooltip = $data['tooltip'];
			echo $data['label'];
			?>
			</div>
			<div class="xiusSpInput field<?php echo $data['info']->key?>">
			<?php if(!empty($xiustooltip) && $data['info']->pluginType != 'Jsfields') :
			 echo '<span class="jomNameTips" title="'.$xiustooltip.'">'.$data['html'].'</span>';
			 else :
				echo $data['html']; 
			endif;?>
			</div>
			</div>
			<?php
		endforeach;
?>		
		<div class="clr"></div>
		
		<div style="display:none;">
		<?php 	echo $this->loadTemplate('joinhtml');	?>
		</div>
		
		<div id="xiusSpSubmit">
		<input type="submit" id="xiussearch" name="xiussearch" value="<?php echo XiusText::_("SEARCH_BUTTON");?>" />
		</div>
		<?php
		endif;
		?>

	<input type="hidden" name="fromPanel" value="true" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<?php 
