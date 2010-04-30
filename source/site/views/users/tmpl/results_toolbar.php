<div class="toolbar">
<?php 

$user =& JFactory::getUser();
$listid = 0;
if(!empty( $this->list )){
	if(isset($this->list->id))
		$listid = $this->list->id;
}
/*only admin will see this icon */
if(XiusHelpersUtils::isAdmin($user->id)){
	$url = "index.php?option=com_xius&view=users&task=displayList&subtask=xiussavelist&listid=".$listid;
	?><img src="<?php echo JURI::base().'components/com_xius/assets/images/save.png';?>" onclick="popup('popUpDiv')" title="Save This List" />
	
</div>

<script type="text/javascript" src="components/com_xius/assets/js/divpop.js">
</script>
		
<?php 
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
	?><img src="<?php echo JURI::base().'components/com_xius/assets/images/excel.png';?>" onClick='location.href="<?php echo JRoute::_($csvurl,false);?>"' title="Export TO CSV" />
	<?php 
}

echo '<i>'.sprintf(JText::_('Total Users %s'),$this->total).'</i>';?>

<div id="blanket" style="display:none;"></div>
<div id="popUpDiv" style="display:none;">
<img src="components/com_xius/assets/images/cancel.png" onclick="popup('popUpDiv')" />
<div class="savemainbox">
	<div class="leftbox">
		<h3>Save As New</h3>
		<div class="lab"><label>Name</label></div>
		<div><input type="text" name="name" /></div>
		<div class="lab"><label>Description</label></div>
		<div><textarea rows="" cols="" name="xius_list_desc"></textarea></div>
		<div>Publish:<input type="radio" name="xius_list_publish" value="1">UnPublish:<input type="radio" name="xius_list_publish" value="0"></div>
		<div class="submit"><input type="submit" value="save" /></div>
		
	</div>
	<div class="rightbox">
		<h3>Save in Existing</h3>
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
	</div>
</div>
	</div>


 <!-- onClick='location.href="<?php //echo JRoute::_($url,false);?>"'-->