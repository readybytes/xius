<?php
JHTML::_('behavior.mootools');
$js = JURI::base().'components/com_xius/assets/js/jquery1.4.2.js';
$document= JFactory::getDocument(); 
$document->addScript($js);
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>');
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("select#"+profileTypeInfoId).change(function(){
		var optionvalue = $("select#" + profileTypeInfoId + " option:selected").val();
		var i=0;

		if ($('div.xius_spMain'))
			$('div.xius_spMain').css("display", "block");

		if ($('div.xius_aiMain'))
			$('div.xius_aiMain').css("display", "block");

		if (optionvalue === '')
			return;

		for (x in hiddenFields){

			if(optionvalue != x)
				continue;
					
			for ( ; i<(hiddenFields[optionvalue].length); i++){
			
				if("field"+hiddenFields[optionvalue][i] === profileTypeInfoId)
					continue;

				if($('div.xius_spMain'))
					$("#field"+hiddenFields[optionvalue][i]).parent().parent('div.xius_spMain').css("display", "none");

				if($('div.xius_aiMain'))				
					$("#field"+hiddenFields[optionvalue][i]).parent().parent('div.xius_aiMain').css("display", "none");
				}
		}
	});
});
	
</script>
<?php
