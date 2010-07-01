/*
 * To show the address bar for proximity search
 */
function xiusShowAddressBox(ele, prefix){
	var formId 		= ele.form.name;
	var mapEle		= prefix + '_gmap_option';
	var addressEle  = prefix + '_address_option';
	document.getElementById(formId).getElementById(mapEle).style.display	 = 'none';
	document.getElementById(formId).getElementById(addressEle).style.display = 'block';
}

/*
 * To show the google map 
 */
function xiusShowGoogleMap(ele, prefix){
	var formId 		= ele.form.name;
	var mapEle		= prefix + '_gmap_option';
	var addressEle  = prefix + '_address_option';
	document.getElementById(formId).getElementById(mapEle).style.display	 = 'block';
	document.getElementById(formId).getElementById(addressEle).style.display = 'none';
}

