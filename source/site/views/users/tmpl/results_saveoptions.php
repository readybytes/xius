<?php 
$css = JURI::base().'components/com_xius/assets/css/save.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
?>
<form action="index.php?option=com_xius&view=users&task=displaySaveOption" name="saveListForm" id="saveListForm" method="post">
<div class="savemainbox">
	<div class="leftbox">
		<h3>Save As New</h3>
		<div class="lab"><label>Name</label></div>
		<div><input type="text" name="xius_list_name" /></div>
		<div class="lab"><label>Description</label></div>
		<div><textarea rows="" cols="" name="xius_list_desc"></textarea></div>
		<div>Publish:<input type="radio" name="xius_list_publish" value="1" checked="checked">Unpublish:<input type="radio" name="xius_list_publish" value="0"></div>
		<div class="submit"><input type="submit" value="save" /></div>
		
	</div>
	<div class="rightbox">
		<h3>Save in Existing</h3>
		<div class="subrightbox"><?php
if(empty($this->lists))	:
	echo JText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		?>
		<div class="listloop">
		<?php 
		$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
		
		if(empty($l->name))
			$name = 'LIST<br />';
		else
			$name = $l->name;
		echo '<input type="radio" name="listid" value="'.$l->id.'" /> ' .ucwords($name)."<br />" ;
		echo $l->description;
		echo "</div>";
	endforeach;
endif;
?>	<div class="submit"><input type="submit" value="save" /></div>
	</div></div>
</div>
</div>
</form>