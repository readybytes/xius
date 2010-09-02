<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$css = JURI::base().'components/com_xius/assets/css/list.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
?>
<div class="">
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=list');?>" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo JText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = JRoute::_('index.php?option=com_xius&view=list&task=showlist&listid='.$l->id,false);
		?>
		<div class="listmain">
		<div class="listtopleft">
		<h1>
		<?php
		$name = $l->name;
		if(empty($name)):
			$name = 'LIST';
		endif;
		
		echo '<a href="'.$url.'">'.JText::_($name).'</a>'
		?></h1>
		</div>
		<div class="listtopright">
		</div>
		<div class="listdesc">
		<?php
		echo JText::_($l->description);
		?><hr />
		</div>
		</div>
		<?php
	endforeach;
endif;
echo $this->pagination->getPagesLinks();
echo $this->pagination->getLimitBox();
?>

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="list" />
<input type="hidden" name="task" value="display" />
</form>
</div>