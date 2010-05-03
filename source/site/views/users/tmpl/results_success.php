<script language="JavaScript">
function refreshParent(url)
{
	window.parent.location.href = url;
	//window.opener.location.href = url;
 parent.SqueezeBox.close();
 }
</script>
<form>
<?php echo $this->data['msg'];?>
<a href="javascript:refreshParent('<?php echo $this->data['url'];?>');">
<input type = "button" value = "close"/></a>
</form>