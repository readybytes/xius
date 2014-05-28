<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
	$("#backtotop").click(function(){ 
	$(window).scrollTop(0);
	});
});
</script>
<?php 
$this->loadAssets('css', 'result.css');

// load jquery
XiusHelperUtils::loadJQuery();

$this->loadAssets('js', 'menus.js');
$this->loadAssets('js', 'result.js');

?>
<?php JHTML::_('behavior.tooltip'); ?>
<div id="xiusResult">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
<div id="xiusFilter">
	<div id="filterHead"><?php echo XiusText::_('FILTERS'); ?>	
	<?php if(!empty($this->appliedInfo)) : ?>
	<div id="xiusClearAll" title="<?php echo XiusText::_('XIUS_CLEAR_ALL_APPLIED_INFO');?>"  onclick="xiusAddSubTask('resetfilter')">
		<img src="components/com_xius/templates/linkedin/assets/images/clear_all.png" title="<?php echo XiusText::_('XIUS_CLEAR_ALL_APPLIED_INFO');?>" onclick="xiusAddSubTask('resetfilter')" />
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
<div id="xiusProfile">
<?php echo $this->loadTemplate('profile');?>
<div class="xiusfr pagination">
<?php echo $this->pagination->getPagesLinks();?>
<img id='backtotop' src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" title="BackToTop" style="float:right;"/>

</div>
</div>
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
</div>
<?php 
