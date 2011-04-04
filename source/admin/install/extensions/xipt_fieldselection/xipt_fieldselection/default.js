jomsQuery(document).ready(function($) {

	jomsQuery.xius.getProfileTypesFields($);

	// when change applied on select list of ProfileTypes
		$("select#" + profileTypeInfoId).change(function() {
			jomsQuery.xius.getProfileTypesFields($);
		});
	});

jomsQuery
		.extend( {
			xius : {
				getProfileTypesFields : function($) {

					optionvalue = $(
							"select#" + profileTypeInfoId + " option:selected")
							.val();

					if ($('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain'))
						$('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain')
								.css("display", "block");

					if (optionvalue === '')
						return;

					for (x in hiddenFields) {

						if (optionvalue != x)
							continue;

						for (i = 0; i < (hiddenFields[optionvalue].length); i++) {

							if ("field" + hiddenFields[optionvalue][i] === profileTypeInfoId)
								continue;
							
							fieldName ="field" + hiddenFields[optionvalue][i];
							if(document.getElementsByName(fieldName).length == 0)
								fieldName = fieldName + "[]";

							 elementId = document.getElementsByName(fieldName);
							 $(elementId).parents('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain')
							 .css("display", "none");
							 
						}
					}
				}
			}
		});