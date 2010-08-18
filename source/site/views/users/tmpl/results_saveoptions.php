<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$css = JURI::base().'components/com_xius/assets/css/xiuspopup.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

$submitUrl = JRoute::_('index.php?option=com_xius&view=users&task=displaySaveOption&subtask=showListData');
?><div class="xiusPopup">
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=displaySaveOption&subtask=showListData'); ?>" name="saveListForm" id="saveListForm" method="post">

	<div class="xiusPopupHeader">
		<span><?php echo JText::_("SAVE LIST"); ?></span>
	</div>
	
	<div class="xiusPopupBox">
	<div class="xiusPopupEntity">
		<div class="xiusPopupLabel">
		<input type="radio" id="xiusListSaveAsNew" name="xiusListSaveAs" value="xiussavenew" checked><span><?php echo JText::_('SAVE AS NEW LIST');?></span>
		<input type="radio" id="xiusListSaveAsExisting" name="xiusListSaveAs" value="xiussaveexisting"><span><?php echo JText::_('SAVE AS EXISTING');?></span>
		</div>
		<div class="xiusPopupControl">		
		<?php
		if(empty($this->lists))	:
			echo JText::_('NO LISTS AVAILABLE');
		else	:
		?>
		<select name="listid" id="listid">
		<?php 	
		foreach($this->lists as $l)	:
			$checked = '';
			$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
	
			if(empty($l->name)):
				$name = 'LIST<br />';
			else :
				$name = $l->name;
			endif;
	
			if($l->id == $this->selectedListId):
				$checked = ' selected=true';
			endif;
	
			echo '<option value="'.$l->id.'" '.$checked.'>'.JText::_(JString::ucwords($name)).'<br />';	
		endforeach;		
		?>
		</select>
		<?php 
		endif;?>
		</div>
	</div>
	</div>	
	<div class="xiusPopupFooter"><input type="submit" name = "xiusListSaveAs" id = "xiusListSaveAs" value=<?php echo JText::_('NEXT')?> onClick = "xiusSaveListAs('<?php echo $submitUrl;?>');"/></div>

<input type="hidden" name="subtask" value="" />
</form>
</div>