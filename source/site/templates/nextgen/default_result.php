<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
$("img:[title='BackToTop']").click(function(){ 
	$(window).scrollTop(0);
	});
});
</script>
<?php 
// for jquery not load
XiusHelperUtils::loadJQuery();

$this->loadAssets('css', 'result.css');
$this->loadAssets('js', 'menus.js');
$this->loadAssets('js', 'result.js');

?>

<?php JHTML::_('behavior.tooltip'); ?>
<div id="xiusProfile">
	<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
		<div id="xiusFilter">
			
			<?php echo $this->loadTemplate('filtered');?>
			
			
			<div id="filters">
			<?php	echo $this->loadTemplate('filters');?>
			</div>
		</div>
<?php echo $this->loadTemplate('toolbar'); ?>
<div id="xiusMiniProfiles">
<?php echo $this->loadTemplate('profile');?>
<div class="xiusfr pagination">
<?php echo $this->pagination->getPagesLinks();?>
<img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" title="BackToTop" style="float:right;"/>
</div>
</div>

<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
</div>