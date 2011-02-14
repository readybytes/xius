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
<div class="xius_result" id="xius_result">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
<?php
// for jquery not load
XiusHelperUtils::loadJQuery();
/*XITODO : pass variable for color */
$this->loadAssets('css','result.css');
$this->loadAssets('js','result.js');

JHTML::_('behavior.tooltip');
echo $this->loadTemplate('filtered');
echo $this->loadTemplate('filters');
echo $this->loadTemplate('toolbar');
echo $this->loadTemplate('profile');
?>
<div class="pagination">
<?php  echo $this->pagination->getPagesLinks(); ?>
</div>

<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
<img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" title="BackToTop" style="float:right;"/>
</div>
