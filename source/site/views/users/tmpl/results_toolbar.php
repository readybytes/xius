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
	?><img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/save.png';?>" onClick='location.href="<?php echo JRoute::_($url,false);?>"' title="Save This List" />
	<?php 
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
	?><img src="<?php echo JURI::base().'administrator/components/com_xius/assets/images/excel.png';?>" onClick='location.href="<?php echo JRoute::_($csvurl,false);?>"' title="Export TO CSV" />
	<?php 
}

echo '<i>'.sprintf(JText::_('Total Users %s'),$this->total).'</i>';?>
</div>

