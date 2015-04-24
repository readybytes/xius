window.joms_queue || (joms_queue = []);
joms_queue.push(function() {
	joms.jQuery(document).ready(function($) {
	
		xius.getProfileTypesFields();
	
		// when change applied on select list of ProfileTypes
		joms.jQuery("select[name=" + profileTypeInfoId+"]").change(function() {
			xius.getProfileTypesFields();
		});
	});
});	

xius = {};
xius.getProfileTypesFields = function() {
	optionvalue = joms.jQuery("select[name=" + profileTypeInfoId+"]")
					.val();
	if (joms.jQuery('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right'))
		joms.jQuery('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right')
				.css("display", "block");

	if (optionvalue === '')
		return;

	for (x in hiddenFields) {

		if (optionvalue != x)
			continue;

		for (i = 0; i < (hiddenFields[optionvalue].length); i++) {

			if ("field" + hiddenFields[optionvalue][i] === profileTypeInfoId)
				continue;
			
			fieldName ="xiusinfo_" + hiddenFields[optionvalue][i]+"1";
			if(document.getElementsByName(fieldName).length == 0)
				fieldName = fieldName + "[]";

			 elementId = document.getElementsByName(fieldName);
			 joms.jQuery(elementId).parents('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right')
			 .css("display", "none");
			 
		}
	}
}
