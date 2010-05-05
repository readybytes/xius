<script language="JavaScript">
function refreshParent(url)
{
	window.parent.location.href = url;
	//window.opener.location.href = url;
 	parent.SqueezeBox.close();
 }
</script>
<div style="margin-top:30%;margin-left:35%;">
	<form>
		<div style="border-bottom:1px solid #275788;width:40%;">
		<?php echo $this->data['msg'];?>
		</div>
		<p>
			<a href="javascript:refreshParent('<?php echo $this->data['url'];?>');">
			<input type = "button" value = "close"/>
			</a>
		</p>
	</form>
</div>