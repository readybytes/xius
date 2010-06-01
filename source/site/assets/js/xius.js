//@Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
//@license GNU/GPL http://www.gnu.org/copyleft/gpl.html

	function deleteInfo(infoid,valueBoxId)
	{
		var form = document.userForm;
		form.xiusdelinfo.value = infoid.id;
		form.conditionvalue.value = document.getElementById(valueBoxId).value;
		form.subtask.value = 'xiusdelinfo';
		form.submit();
	}

	function applyJoin(subtask) 
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}

	function addSubTaskAndSubmit(subtask)
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function addInfo(infoid) 
	{
		var form = document.userForm;
		form.xiusaddinfo.value = infoid;
		form.subtask.value = 'xiusaddinfo';
		form.submit();
	}
	
	function saveList(subtask) 
	{
		var form = document.saveListForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function applySort(subtask) 
	{
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
	function refreshParent(url)
	{
		window.parent.location.href = url;
		//window.opener.location.href = url;
	 	parent.SqueezeBox.close();
	 }