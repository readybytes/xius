
function listSelectUser( ) {
	var tempId = new Array();
    for (var i = 0; true; i++) {
    	var str = 'xiusCheckUser' + i;
    	var cbx = window.top.document.forms.userForm.getElementById(str);
    	if (!cbx) break;
        if(cbx.checked == true)
           	tempId[i] = cbx.value;
        } // for
    var hid1 = document.getElementById('xius_selected_userid');
    hid1.value = tempId;    
}
 