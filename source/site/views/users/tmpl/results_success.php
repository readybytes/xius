<script language="JavaScript">
function refreshParent(url)
{
	window.parent.location.href = url;
	//window.opener.location.href = url;
 parent.SqueezeBox.close();
 }
</script>
<form>
<a href="javascript:refreshParent('<?php echo $this->data['url'];?>');"><form>
<input type = "button" value = "close"/></a>
</form>