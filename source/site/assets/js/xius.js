//@Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
//@license GNU/GPL http://www.gnu.org/copyleft/gpl.html

	function xiusDeleteInfo(infoid,valueBoxId)
	{
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		form.subtask.value = 'xiusdelinfo';
		form.submit();
	}

	function xiusApplyJoin(subtask) 
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}

	function xiusAddSubTask(subtask)
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function xiusAddInfo(infoid) 
	{
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		form.subtask.value = 'xiusaddinfo';
		form.submit();
	}
	
	function xiusSaveList(subtask) 
	{
		var form = document.saveListForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function xiusApplySort(subtask) 
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function xiusRefreshParent(url)
	{
		window.parent.location.href = url;
		//window.opener.location.href = url;
	 	parent.SqueezeBox.close();
	 }