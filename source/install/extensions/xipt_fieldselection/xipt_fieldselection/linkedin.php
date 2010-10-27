
<script type="text/javascript">

jQuery.extend({
	xius: {
			getProfileTypesFields :function($){

						var optionvalue = $("select#" + profileTypeInfoId + " option:selected").val();
						var i=0;

						if ($('div.xiusSpMain'))
							$('div.xiusSpMain').css("display", "block");

						if ($('div.xiusFlData'))
							$('div.xiusFlData').css("display", "block");

						if (optionvalue === '')
							return;

						for (x in hiddenFields){

							if(optionvalue != x)
								continue;

							for ( ; i<(hiddenFields[optionvalue].length); i++){

								if("field"+hiddenFields[optionvalue][i] === profileTypeInfoId)
									continue;

								if($('div.xiusSpMain'))
									$("#field"+hiddenFields[optionvalue][i]).parent().parent('div.xiusSpMain').css("display", "none");

								if($('div.xiusFlData'))
									$("#field"+hiddenFields[optionvalue][i]).parent().parent('div.xiusFlData').css("display", "none");
								}
							}
						}
			}
		});
</script>
<?php
