function xiusListSelectUser() {
	// check message box or subject box are empty or not when comes from email window
	if( checkEmailSubjectExist() == false){
		alert("Subject can not be empty.");
		return false;
	}
			
	/*if( checkEmailMessageExist() == false){
		alert("Message Box can not be empty.");
		return false;
	}*/
	
	var tempId = new Array();
    for (var i = 0; true; i++) {
    	var str = 'xiusCheckUser' + i;
    	var cbx = parent.document.getElementById(str);
    	if (!cbx) break;
        if(cbx.checked == true)
           	tempId[i] = cbx.value;
        } // for
    var hid1 = document.getElementById('xiusSelectedUserid');
    hid1.value = tempId;
    return true;
}

function checkEmailSubjectExist(){
	var subject = document.getElementById('xiusEmailSubjectEl');
	if(trim(subject.value)=="")
		return false;
	return true;
}

function checkEmailMessageExist(){
	var message = document.getElementById('xiusEmailMessageEl');
	var str= message.getContent();
	if(trim(str)=="")
		return false;
	return true;
}