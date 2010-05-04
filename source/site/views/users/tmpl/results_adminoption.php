<div class = "toolbar_top_left"><?php 
$params	= array('size'=>array('x' => 500 , 'y' => 450));
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
	
	$url = "index.php?option=com_xius&view=users&task=displaySaveOption&tmpl=component&listid=".$listid;
	?><a class = 'savelist' href="<?php echo $url;?>" rel = "{handler: 'iframe', size: {x: 500 , y: 450}}" >
	<img src="<?php echo JURI::base().'components/com_xius/assets/images/save.png';?>" title=<?php echo JText::_("Save This List"); ?> />
	</a>
	

	
<?php 
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
	?><img src="<?php echo JURI::base().'components/com_xius/assets/images/excel.png';?>" onClick='location.href="<?php echo JRoute::_($csvurl,false);?>"' title="Export TO CSV" />
	<?php 
}?>

</div>
