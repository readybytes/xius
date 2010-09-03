<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/ 
$listid = 0;

if(!empty( $this->list ))	:
	$listid = $this->list->id;
	if(empty($this->list->name)):
		$name = 'LIST'.$listid;
	else :
		$name = $this->list->name;
	endif;
		
	echo JText::_($name);

endif;
?>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />