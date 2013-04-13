//@Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
//@license GNU/GPL http://www.gnu.org/copyleft/gpl.html
	
	function xiusDeleteInfo(infoid,valueBoxId)
	{		
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		
		form.task.value = 'delinfo';
		form.submit();
	}

	function xiusApplyJoin(task) 
	{		
		var form = document.userForm;
		
		form.task.value = task;	
		form.submit();
	}

	function xiusAddSubTask(task)
	{
		var form = document.userForm;
		
		form.task.value = task;		
		form.submit();
	}
	
	function xiusAddInfo(infoid) 
	{
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		
		form.task.value = 'addinfo';	
		form.submit();
	}
	
	function xiusSaveList(task) 
	{
		var form = document.saveListForm;
		
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
			if(name.trim()=="-1"){
				alert('You have not selected any List or Not created any list yet.')
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
		if(name.trim() == ''){
			alert('Please enter the name of List');
			return false;
		}
	
		return true;			
	}
	
	function xiusApplySort(task) 
	{
		var form = document.userForm;
		
		form.task.value = task;
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
		document.getElementById("xius_ai").setAttribute("class", "xius_ai");
	}

	function xiusshowdiv()
	{
		document.getElementById("xiushide").setAttribute("class", "xiusSlider");
		document.getElementById("xiusSliderImg").setAttribute("class", "xiusSlideImgUp");
		document.getElementById("xius_ai").setAttribute("class", "xius_ai_full");
	}