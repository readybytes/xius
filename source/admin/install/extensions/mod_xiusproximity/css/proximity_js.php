<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>

jQuery(document).ready(function($){
	$('div#keywordHtml').children('input.inputbox').attr('value','<?php echo XiusText::_("FIND");?>').css('color','<?php echo $background; ?>');
	$('div#xiusProxiAddress').children('input#xiusAddress').attr('value','<?php echo XiusText::_("NEAR");?>').css('color','<?php echo $background; ?>');
	$('input#xiusDistanceInput').css('color','<?php echo $background; ?>');
	
	$('div#keywordHtml').children('input.inputbox').focus(function(){
		$(this).css('color','<?php echo $color; ?>');
		if($(this).attr('value') == '<?php echo XiusText::_("FIND");?>'){
			$(this).attr('value','');
		}
	});

	$('div#keywordHtml').children('input.inputbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value','<?php echo XiusText::_("FIND");?>');
			$(this).css('color','<?php echo $background; ?>');
		}
	});
	
	$('div#xiusProxiAddress').children('input#xiusAddress').focus(function(){
		$(this).css('color','<?php echo $color; ?>');
		if($(this).attr('value') == '<?php echo XiusText::_("NEAR")?>'){
			$(this).attr('value','');
		}
	});

	$('div#xiusProxiAddress').children('input#xiusAddress').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value','<?php echo XiusText::_("NEAR");?>');
			$(this).css('color','<?php echo $background; ?>');
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

	$('input#xiusDistanceInput').focus(function(){
		$(this).css('color','<?php echo $color; ?>');
	});
	
	$('input#xiusDistanceInput').blur(function(){
		if($(this).attr('value') == '10'){
		$(this).css('color','<?php echo $background; ?>');
		}
	});
	

});
<?php 