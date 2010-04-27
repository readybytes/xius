<div class="toolbar">
<div class="total">
<?php 

$user =& JFactory::getUser();
$listid = 0;
if(!empty( $this->list ))
	$listid = $this->list->id;
/*only admin will see this icon */
if(XiusHelpersUtils::isAdmin($user->id)){
	$url = "index.php?option=com_xius&view=users&task=displayList&subtask=xiussavelist&listid=".$listid;
	echo '<a href="'.JRoute::_($url,false).'" />'.JText::_('SAVE THIS LIST').'</a>';
	echo ":-) You are online";
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
	echo '<a href="'.JRoute::_($csvurl,false).'" />'.JText::_('EXPORT INTO CSV').'</a>';
}
else
	echo " :-( You are offline , please go from my space";

echo '<h4 align="center"><i>'.sprintf(JText::_('Total Users %s'),$this->total).'</i></h4>';?>
</div>
</div>