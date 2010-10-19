<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

//Call XIUS Functions
$document =& JFactory::getDocument();
JHTML::_('behavior.mootools');
$js = JURI::base().'components/com_xius/assets/js/jquery1.4.2.js';
$document->addScript($js);
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>');
$document->addStyleSheet('modules/mod_xiusproximity/css/'.$params->get('xius_color', 'blue').'_proximity.css');
// XITODO : Move scripts to module's js file
?>

<script><!--
jQuery(document).ready(function($){
	$('div#keywordHtml').children('input.inputbox').attr('value','<?php echo XiusText::_("FIND");?>');
	$('div#xiusProxiAddress').children('input#xiusAddress').attr('value','<?php echo XiusText::_("NEAR");?>');
	
	$('div#keywordHtml').children('input.inputbox').focus(function(){
		if($(this).attr('value') == '<?php echo XiusText::_("FIND");?>'){
			$(this).attr('value','')
		}
	});

	$('div#keywordHtml').children('input.inputbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value','<?php echo XiusText::_("FIND");?>')
		}
	});
	
	$('div#xiusProxiAddress').children('input#xiusAddress').focus(function(){
		if($(this).attr('value') == '<?php echo XiusText::_("NEAR")?>'){
			$(this).attr('value','')
		}
	});

	$('div#xiusProxiAddress').children('input#xiusAddress').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value','<?php echo XiusText::_("NEAR");?>')
		}
	});

	$('div#xiusProximity').children('form').submit(function(){
		var address = $('div#xiusProxiAddress').children('input#xiusAddress');
		if(address.attr('value') == '<?php echo XiusText::_("NEAR");?>'){
			address.attr('value','');
		}
		var keyword = $('div#keywordHtml').children('input.inputbox');
		if(keyword.attr('value') == '<?php echo XiusText::_("FIND");?>'){
			keyword.attr('value','');
		}	
	});

});
</script>

	<div id="xiusProximity">
	<?php 

	if(isset($displayKeyword['html'])
	 ||isset($displayProximity['html'])):  ?>
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo JRoute::_($link,false);?>"  method=post>
			<div id="xiusKeyword">
			<div id="keywordHtml"><?php if($displayKeyword['html']) echo $displayKeyword['html'];?></div>
			</div>
			
			<div id="proximityDiv">
				<div id="proximityHtml"><?php if($displayProximity['html']) echo $displayProximity['html'];?></div>
			</div>
			
			<input type="hidden" name="fromPanel" value="true" />
			
			<div id="searchButton">
			 <input id="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('SEARCH'); ?>" />
			</div>

		</form>
		<?php else: ?>
			<div id="xiusProxiError">
				<?php echo XiusText::_("ALL SEARCHABLE INFORMATION HAS BEEN DISABLED BY ADMINISTRATOR");?>
			</div>
		<?php endif; ?>
	</div>