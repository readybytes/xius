<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$css = JURI::base().'components/com_xius/assets/css/save.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

?><div class="savemainbox">
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=displaySaveOption&tmpl=component'); ?>" name="saveListForm" id="saveListForm" method="post">

	<div class="leftbox">
		<h3><?php echo JText::_("Save As New"); ?></h3>
		<div class="lab"><label><?php echo JText::_('Name');?></label></div>
		<div><input type="text" name="xius_list_name" /></div>
		<div class="lab"><label><?php echo JText::_('Description');?></label></div>
		<div><textarea rows="" cols="" name="xius_list_desc"></textarea></div>
		<div><?php echo JText::_('Published');?>:<input type="radio" name="xius_list_publish" value="0"><?php echo JText::_('NO');?>:<input type="radio" name="xius_list_publish" value="1" checked="checked"><?php echo JText::_('YES');?></div>
		<div class="submit"><input type="submit" name = "xiussavenew" id = "xiussavenew" value=<?php echo JText::_('SAVE AS NEW')?> onClick = "xiusSaveList('xiussavenew');"/></div>
	</div>
	<div class="rightbox">
		<h3><?php echo JText::_('Save in Existing');?></h3>
		<div class="subrightbox">
		<?php
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

		echo '<input type="radio" name="listid" value="'.$l->id.'" '.$checked.' /> ' .JText::_(JString::ucwords($name))."<br />" ;
		echo "</div>";
	endforeach;?>
	<div class="submit"><input type="submit" name = "xiussaveexisting" id = "xiussaveexisting" value=<?php echo JText::_('SAVE AS EXISTING')?> onClick = "xiusSaveList('xiussaveexisting');"/></div>
<?php
endif;?>

	</div></div>
</div>

<input type="hidden" name="subtask" value="" />
</form>
</div>
