<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_result" id="xius_result"><a name="xiustop"></a>
<form action="<?php echo JRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
<?php
/*XITODO : pass variable for color */
$css = JURI::base().'components/com_xius/assets/css/gray.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
JHTML::_('behavior.tooltip');
echo $this->loadTemplate('filtered');
echo $this->loadTemplate('filters');
echo $this->loadTemplate('toolbar');
echo $this->loadTemplate('profile');
?>
<div>
<?php  echo $this->pagination->getPagesLinks(); ?>
</div>

<?php
	$viewName = 'view';
	$taskName = 'task';
	 
	if($this->_isExternalUrl === true):
		$viewName = 'xiusview';
		$taskName = 'xiustask';
	endif;
	?>
<input type="hidden" name="isExternalUrl" value="<?php echo $this->_isExternalUrl;?>" />
<input type="hidden" name="<?php echo $viewName;?>" value="users" />
<input type="hidden" name="<?php echo $taskName;?>" value="search" />
</form>
<a href="#xiustop" style="float:right;"><img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" /></a>
</div>
