<div class="">
<form action="index.php?option=com_xius&view=users" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo JText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
		?>
		<div style="overflow: hidden; margin-top: 3px;">
		<div style="width:25%; float:left; color:#A8A8A8;">
		<h1 style="margin:4px;">
		<?php 
		$name = $l->name;
		if(empty($name))
			$name = 'LIST';
			
		echo '<a href="'.$url.'">'.$name.'</a>'
		?></h1>
		</div>
		<div style="width:75%; float: right;">
		</div>
		<!--  echo '<a href="'.$url.'">'.$name.$l->id.'</a>';-->
		<div style="width:100%;float: left;min-height: 40px; margin: 4px;">
		<?php 
		echo $l->description;
		?><hr />
		</div>
		</div>
		<?php 
	endforeach;
endif;
echo $this->pagination->getPagesLinks();
echo $this->pagination->getLimitBox();
?>	

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="displayList" />
</form>
</div>