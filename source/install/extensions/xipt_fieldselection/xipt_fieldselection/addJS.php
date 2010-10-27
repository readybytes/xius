<?php
JHTML::_('behavior.mootools');
$js = JURI::base().'components/com_xius/assets/js/jquery1.4.2.js';
$document= JFactory::getDocument(); 
$document->addScript($js);
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>');
?>

<script type="text/javascript">
jQuery(document).ready(function($){

	jQuery.xius.getProfileTypesFields($);

	// when change applied on select list of ProfileTypes
	$("select#"+profileTypeInfoId).change(function(){
			jQuery.xius.getProfileTypesFields($);
			});
});
</script>

<?php 
		//XITODO:: use diffrent way for load JS files (not use required once)
  
		// find template and add path
		$template	= XiusHelpersUtils::getConfigurationParams('xiusTemplates','default');
		$path 	  	= JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.'xipt_fieldselection'.DS.$template.'.php';
		require_once $path;
