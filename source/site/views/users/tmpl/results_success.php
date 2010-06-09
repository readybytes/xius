<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div style="margin-top:30%;margin-left:35%;">
	<form>
		<div style="border-bottom:1px solid #275788;width:40%;">
		<?php echo $this->data['msg'];?>
		</div>
		<p>
			<a href="javascript:xiusRefreshParent('<?php echo $this->data['url'];?>');">
			<input type = "button" value = "close"/>
			</a>
		</p>
	</form>
</div>