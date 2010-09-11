<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<?php 
$css = JURI::base().'components/com_xius/assets/css/nextgen.css';
$js2 = JURI::base().'components/com_xius/assets/js/xius_jquery.js';
$js1 = JURI::base().'components/com_xius/assets/js/jquery.js';
$js3 = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
JHTML::_('behavior.mootools');
$document->addScript($js1);
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );
$document->addScript($js2);
$document->addScript($js3);
?><!--[if IE 6]>
	
  <![endif]-->

<?php JHTML::_('behavior.tooltip'); ?>
<div id="xiusProfile">
	<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=search');?>" name="userForm" id="userForm" method="post">
		<div id="xiusFilter">
			<div id="xiusFiltered">
			<?php echo $this->loadTemplate('filtered');?>
			</div>
			
			<div id="filters">
			<?php	echo $this->loadTemplate('filters');?>
			</div>
		</div>
<?php echo $this->loadTemplate('toolbar'); ?>
<div id="xiusMiniProfiles">
<?php echo $this->loadTemplate('profile');?>
<div class="pagination">
<?php echo $this->pagination->getPagesLinks();?>
</div>
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
</form>
</div>