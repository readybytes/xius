<?php 
$listid = 0;

if(!empty( $this->list ))	:
	$listid = $this->list->id;
	if(empty($this->list->name))
		$name = 'LIST'.$listid;
	else
		$name = $this->list->name;
		
	echo JText::_($name);

endif;
?>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />