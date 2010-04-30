<div class="toolbar">
<?php 
$params	= array('size'=>array('x' => 500 , 'y' => 650), 'onClose' => 'refreshParent();');
JHTML::_('behavior.modal' , 'a.savelist' , $params);
$user =& JFactory::getUser();
$listid = 0;
if(!empty( $this->list )){
	if(isset($this->list->id))
		$listid = $this->list->id;
}
/*only admin will see this icon */
if(XiusHelpersUtils::isAdmin($user->id)){
	//$url = "index.php?option=com_xius&view=users&task=displayList&subtask=xiussavelist&listid=".$listid;
	
	$url = "index.php?option=com_xius&view=users&task=displaySaveOption&prevtask=".$this->task."&tmpl=component&listid=".$listid;
	?><a class = 'savelist' href="<?php echo $url;?>" rel = "{handler: 'iframe', size: {x: 650 , y: 470}}" >
	<img src="<?php echo JURI::base().'components/com_xius/assets/images/save.png';?>" title="Save This List" />
	</a>
	

	
<?php 
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
	?><img src="<?php echo JURI::base().'components/com_xius/assets/images/excel.png';?>" onClick='location.href="<?php echo JRoute::_($csvurl,false);?>"' title="Export TO CSV" />
	<?php 
}

echo '<i>'.sprintf(JText::_('Total Users %s'),$this->total).'</i>';?>
</div>