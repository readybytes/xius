<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_result" id="xius_result"><a name="xiustop"></a>
<?php
//$listid=''; 
//if(isset($this->list) && isset($this->list->id) && !empty($this->list->id))
//	$listid = 'listid='.$this->list->id;
?>
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=search');?>" name="userForm" id="userForm" method="post">
<?php
/*XITODO : pass variable for color */
$css = JURI::base().'components/com_xius/assets/css/gray.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
JHTML::_('behavior.tooltip');
if($this->task == 'showlist')
	echo '<span class = "xiusListname">'.JTEXT::_(ucfirst($this->loadTemplate('listinfo'))).'</span>';

include_once('searched_fields.php');
include_once('searchable_fields.php');
include_once('toolbar.php');
include_once('miniprofile.php');
//include('userlisting.php');
//include('pagination.php');
?>
<div>
<?php
echo $this->pagination->getPagesLinks();
?>
</div>

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
<a href="#xiustop" style="float:right;"><img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" /></a>
</div>
