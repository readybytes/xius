<div class="toolbar">
<div class="total">
<?php 

$user =& JFactory::getUser();

if($user->id){
	$url = "index.php?option=com_xius&view=search&task=savelist";
	echo '<a href="'.JRoute::_($url,false).'" />'.JText::_('SAVE THIS LIST').'</a>';
	echo ":-) You are online";
}
else
	echo " :-( You are offline , please go from my space";

echo '<h4 align="center"><i>'.sprintf(JText::_('Total Users %s'),$this->total).'</i></h4>';?>
</div>
</div>