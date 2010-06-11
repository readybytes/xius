<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_result"><a name="xiustop"></a>
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&supplytask=displayresult');?>" name="userForm" id="userForm" method="post">
<?php
/*XITODO : pass variable for color */
$css = JURI::base().'components/com_xius/assets/css/blue.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
JHTML::_('behavior.tooltip');
if($this->task == 'displayList')
	echo '<span class = "xiusListname">'.JTEXT::_(ucfirst($this->loadTemplate('listinfo'))).'</span>';
echo $this->loadTemplate('appliedinfo');

//jimport('joomla.application.module.helper');
//$module =& JModuleHelper::getModule('mod_available_info');
//echo JModuleHelper::renderModule($module);

echo $this->loadTemplate('availableinfo');
?>
<?php
echo $this->loadTemplate('toolbar');
?>
<?php
echo $this->loadTemplate('userlisting');
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
<input type="hidden" name="task" value="<?php echo $this->task;?>" />
<input type="hidden" name="subtask" value="" />
<input type="hidden" name="scanned" value="1" />
</form>
<a href="#xiustop" style="float:right;"><img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" /></a>
</div>
