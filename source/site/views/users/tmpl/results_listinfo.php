<?php 
$listid = 0;

if(!empty( $this->list ))
	$listid = $this->list->id;
	if(empty($this->list->name))
		echo $name = 'LIST';
	else
		echo $name = $this->list->name;
?>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />