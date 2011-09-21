function xiusListSelectUser() {
	// check message box or subject box are empty or not when comes from email window
	if( xiusCheckEmailSubjectExist() == false){
		alert("Subject can not be empty.");
		return false;
	}
			
	if( xiusCheckEmailMessageExist() == ""){
		alert("Message Box can not be empty.");
		return false;
	}
	
	var tempId = new Array();
	var count=0;
    for (var i = 0; true; i++) {
    	var str = 'xiusCheckUser' + i;
    	var cbx = parent.document.getElementById(str);
    	if (!cbx) break;
        if(cbx.checked == true){
           	tempId[count] = cbx.value;
           	count++;
       	}
    } // for
    var hid1 = document.getElementById('xiusSelectedUserid');
    hid1.value = tempId;
    return true;
}

function xiusCheckEmailSubjectExist(){
	var subject = document.getElementById('xiusEmailSubjectEl');
	if((subject.value).trim() == "")
		return false;
	return true;
}

function xiusCheckUserSelected(){
	var flag = false;
	for (var i = 0; true; i++) {
		var str = 'xiusCheckUser' + i;
		var cbx = document.getElementById(str);
		if (!cbx) break;
    	if(cbx.checked == true)
           	flag = true;
        } // for
	var a = document.getElementById('xius_emailselected_button');
	if(flag==false){	
		a.href+='&selected=no';
		return false;
	}   
	a.href+='&selected=yes';
	return true;    			
}
