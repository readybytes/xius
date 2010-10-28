<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$this->loadAssets('css', 'result.css');

// load jquery
XiusHelpersUtils::loadJQuery();

$this->loadAssets('js', 'menus.js');
$this->loadAssets('js', 'result.js');

?>
<?php JHTML::_('behavior.tooltip'); ?>
<div id="xiusResult">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
<div id="xiusFilter">
	<div id="filterHead"><?php echo XiusText::_('FILTERS'); ?>	
	<?php if(!empty($this->appliedInfo)) : ?>
	<div id="xiusClearAll" title="<?php echo XiusText::_('XIUS CLEAR ALL APPLIED INFO');?>"  onclick="xiusAddSubTask('resetfilter')">
		<img src="components/com_xius/templates/linkedin/assets/images/clear_all.png" title="<?php echo XiusText::_('XIUS CLEAR ALL APPLIED INFO');?>" onclick="xiusAddSubTask('resetfilter')" />
	</div>
	<?php endif; ?>
	</div>	
<div id="filterForm">	
<?php echo $this->loadTemplate('filtered');?>
<?php echo $this->loadTemplate('filters');
	  echo $this->loadTemplate('joinhtml');?>
</div>
</div>
<?php echo $this->loadTemplate('toolbar'); ?>
<?php echo $this->loadTemplate('profile');?>
<div class="xiusfr">
<?php echo $this->pagination->getPagesLinks();?>
</div>
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
</div>
<?php 
