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

							 elementId = document.getElementsByName("field" + hiddenFields[optionvalue][i]);
							 $(elementId).parents('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain')
							 .css("display", "none");
						}
					}
				}
			}
		});