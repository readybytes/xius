<form action="index.php?option=com_xius&view=users" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo JText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
		
		if(empty($l->name))
			$name = 'LIST';
		else
			$name = $l->name;
		echo '<a href="'.$url.'">'.$name.$l->id.'</a>';
		echo $l->description;
		echo "\n";
	endforeach;
endif;
?>	

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="displayList" />
</form>
