<?php 
echo "LIST INFO";
$listid = 0;
if(!empty( $this->list ))
	$listid = $this->list->id;
?>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />