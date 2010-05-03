<script language="javascript" type="text/javascript">
	function saveList(subtask) {
		var form = document.saveListForm;
		form.subtask.value = subtask;
		form.submit();
	}
	
</script>
<?php 
$css = JURI::base().'components/com_xius/assets/css/save.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
?>
<form action="index.php?option=com_xius&view=users&task=displaySaveOption&tmpl=component" name="saveListForm" id="saveListForm" method="post">
<div class="savemainbox">
	<div class="leftbox">
		<h3>Save As New</h3>
		<div class="lab"><label><?php echo JText::_('Name');?></label></div>
		<div><input type="text" name="xius_list_name" /></div>
		<div class="lab"><label><?php echo JText::_('Description');?></label></div>
		<div><textarea rows="" cols="" name="xius_list_desc"></textarea></div>
		<div><?php echo JText::_('Publish');?>:<input type="radio" name="xius_list_publish" value="1" checked="checked"><?php echo JText::_('Unpublish');?>:<input type="radio" name="xius_list_publish" value="0"></div>
		<div class="submit"><input type="submit" name = "xiussavenew" id = "xiussavenew" value=<?php echo JText::_('SAVE AS NEW')?> onClick = "saveList('xiussavenew');"/></div>
		
	</div>
	<div class="rightbox">
		<h3><?php echo JText::_('Save in Existing');?></h3>
		<div class="subrightbox"><?php
if(empty($this->lists))	:
	echo JText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$checked = '';
		?>
		<div class="listloop">
		<?php 
		$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
		
		if(empty($l->name))
			$name = 'LIST<br />';
		else
			$name = $l->name;
			
		if($l->id == $this->selectedListId)
			$checked = ' checked=checked';
			
		echo '<input type="radio" name="listid" value="'.$l->id.'" '.$checked.' /> ' .JText::_(ucwords($name))."<br />" ;
		echo "</div>";
	endforeach;
endif;
?>	<div class="submit"><input type="submit" name = "xiussaveexisting" id = "xiussaveexisting" value=<?php echo JText::_('SAVE AS EXISTING')?> onClick = "saveList('xiussaveexisting');"/></div>
	</div></div>
</div>
</div>
<input type="hidden" name="subtask" value="" />
</form>