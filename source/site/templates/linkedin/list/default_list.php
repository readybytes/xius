<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<style>
#xiusListName {
	padding:2px;
	font-style: italic;
	font-weight: bold;
}
</style>

<span id = "xiusListName">
<?php 
$listid = 0;
// XITODO : cleanup code
if(!empty( $this->list ))	:
	$listid = $this->list->id;
	if(empty($this->list->name)):
		$name = 'LIST'.$listid;
	else :
		$name = $this->list->name;
	endif;
		
	echo XiusText::_($name);

endif;
?>
</span>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />
<?php 
echo $this->loadTemplate('result');