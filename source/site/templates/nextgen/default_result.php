<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<?php 
$this->loadAssets('css', 'nextgen.css');
$this->loadAssets('js', 'jquery.js');
$this->loadAssets('js', 'xius_jquery.js');
$this->loadAssets('js', 'xius.js');

$document =& JFactory::getDocument();
JHTML::_('behavior.mootools');
$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

?><!--[if IE 6]>
	
  <![endif]-->

<?php JHTML::_('behavior.tooltip'); ?>
<div id="xiusProfile">
	<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=search');?>" name="userForm" id="userForm" method="post">
		<div id="xiusFilter">
			
			<?php echo $this->loadTemplate('filtered');?>
			
			
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