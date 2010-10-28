jQuery(document).ready(function($) {

	jQuery.xius.getProfileTypesFields($);

	// when change applied on select list of ProfileTypes
		$("select#" + profileTypeInfoId).change(function() {
			jQuery.xius.getProfileTypesFields($);
		});
	});

jQuery
		.extend( {
			xius : {
				getProfileTypesFields : function($) {

					optionvalue = $(
							"select#" + profileTypeInfoId + " option:selected")
							.val();

					if ($('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain'))
						$(
								'div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain')
								.css("display", "block");

					if (optionvalue === '')
						return;

					for (x in hiddenFields) {

						if (optionvalue != x)
							continue;

						for (i = 0; i < (hiddenFields[optionvalue].length); i++) {

							if ("field" + hiddenFields[optionvalue][i] === profileTypeInfoId)
								continue;

							if ($('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain'))
								$("#field" + hiddenFields[optionvalue][i])
										.parent()
										.parent('div.xius_spMain, div.xius_aiMain, div.xiusFlData, div.xiusSpMain')
										.css("display", "none");
						}
					}
				}
			}
		});