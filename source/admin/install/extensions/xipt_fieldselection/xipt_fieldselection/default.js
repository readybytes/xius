jomsQuery(document).ready(function($) {

	jomsQuery.xius.getProfileTypesFields($);

	// when change applied on select list of ProfileTypes
		$("select[name=" + profileTypeInfoId+"]").change(function() {
			jomsQuery.xius.getProfileTypesFields($);
		});
	});

jomsQuery
		.extend( {
			xius : {
				getProfileTypesFields : function($) {
					optionvalue = $("select[name=" + profileTypeInfoId+"]")
									.val();
					if ($('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right'))
						$('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right')
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
							 $(elementId).parents('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain,div.xiusMod_availablemain,div.xiMod_left,div.xiMod_right')
							 .css("display", "none");
							 
						}
					}
				}
			}
		});