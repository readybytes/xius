//@Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
//@license GNU/GPL http://www.gnu.org/copyleft/gpl.html

	function isFromExternalUrl()
	{
		var form = document.userForm;
		var value = form.isExternalUrl.value;
		
		return value;
		/*if(value == true)
			return true;
		
		return false;*/		
	}
	
	function xiusDeleteInfo(infoid,valueBoxId)
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		
		if(isExternalUrl)
			form.xiustask.value = 'delinfo';
		else 
			form.task.value = 'delinfo';
		
		form.submit();
	}

	function xiusApplyJoin(task) 
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.userForm;
		
		if(isExternalUrl)
			form.xiustask.value = task
		else
			form.task.value = task;
		
		form.submit();
	}

	function xiusAddSubTask(task)
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.userForm;
		
		if(isExternalUrl)
			form.xiustask.value = task;
		else
				form.task.value = task;
		
		form.submit();
	}
	
	function xiusAddInfo(infoid) 
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		
		if(isExternalUrl)
			form.xiustask.value = 'addinfo';
		else
			form.task.value = 'addinfo';
		
		form.submit();
	}
	
	function xiusSaveList(task) 
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.saveListForm;
		
		if(isExternalUrl)
			form.xiustask.value = task;
		else
			form.task.value = task;
		
		form.submit();
	}
	
	function xiusSaveListAs(url)
	{
		var task = '';
		if(document.getElementById('xiusListSaveAsNew').checked==true)
			saveAs = '&isnew=true';
		
		if(document.getElementById('xiusListSaveAsExisting').checked==true){
			
			var name = document.getElementById('listid').value;
			if(trim(name) == '-1'){
				alert('You have not selected any List or Not cretaed any list yet.')
				return false;
			}
			
			saveAs = '&isnew=false';
			var listid = document.getElementById('listid').value;
			saveAs = saveAs + '&listid=' + listid;
		}

		window.parent.location.href = url + saveAs;
		//window.opener.location.href = url;
		parent.SqueezeBox.close();
	}
	
	function xiusListValidation(){
		var name = document.getElementById('xiusListName').value;
		if(trim(name) == ''){
			alert('Please enter the name of List');
			return false;
		}
	
		return true;			
	}
	
	function xiusApplySort(subtask) 
	{
		var isExternalUrl = isFromExternalUrl();
		var form = document.userForm;
		
		if(isExternalUrl)
			form.xiustask.value = subtask;
		else
			form.task.value = subtask;
		form.submit();
	}
	
	function xiusRefreshParent(url)
	{
		window.parent.location.href = url;
		//window.opener.location.href = url;
	 	parent.SqueezeBox.close();
	 }
	
	function xiushideshowdiv()
	{
		if(document.getElementById("xiushide").className=="xiusSliderHide")
		{
			xiusshowdiv();
		}
		else
		{
			xiushidediv();	
		}
	}

	function xiushidediv()
	{
		document.getElementById("xiushide").setAttribute("class", "xiusSliderHide");
		document.getElementById("xiusSliderImg").setAttribute("class", "xiusSlideImgDown");	
	}

	function xiusshowdiv()
	{
		document.getElementById("xiushide").setAttribute("class", "xiusSlider");
		document.getElementById("xiusSliderImg").setAttribute("class", "xiusSlideImgUp");
	}