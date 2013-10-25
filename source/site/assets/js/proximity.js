/*
 * To show the address bar for proximity search
 */
function xiusShowAddressBox(ele, prefix,lat,long){
	var formId 		= ele.form.name;
	var latitude	= prefix + '_lat';
	var longitude	= prefix + '_long';
	var mapEle		= prefix + '_gmap_option';
	var addressEle  = prefix + '_address_option';

	document.getElementById(prefix + '_lat').value	= lat;
	document.getElementById(longitude).value		 = long ;
	document.getElementById(mapEle).style.display	 = 'none';
	document.getElementById(addressEle).style.display = 'block';
}

/*
 * To show the google map 
 */
function xiusShowGoogleMap(ele, prefix,lat,long){
	var formId 		= ele.form.name;
	var latitude	= prefix + '_lat';
	var longitude	= prefix + '_long';
	var mapEle		= prefix + '_gmap_option';
	var addressEle  = prefix + '_address_option';

	document.getElementById(latitude).value				= lat;
	document.getElementById(longitude).value			= long ;
	document.getElementById(mapEle).style.display	 = 'block';
	document.getElementById(addressEle).style.display = 'none';
	
	// Xipt can hide this link by JSToolbar privacy
	document.getElementById(mapEle).getElementsByTagName("a")[0].style.display	 = 'block';
}
/*
 * Set default user location
 */
function xiusAddMyLocation(ele, prefix,lat,long){
	var formId 		= ele.form.name;
	var latitude	= prefix + '_lat';
	var longitude	= prefix + '_long';
	var mapEle		= prefix + '_gmap_option';
	var addressEle  = prefix + '_address_option';

	document.getElementById(latitude).value				= lat;
	document.getElementById(longitude).value			= long ;
	document.getElementById(mapEle).style.display		= 'none';
	document.getElementById(addressEle).style.display	= 'none';
}
