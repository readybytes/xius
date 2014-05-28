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
<div class="xiusfr pagination">
<?php  echo $this->pagination->getPagesLinks(); ?>
</div>

<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
<img id='backtotop' src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" title="BackToTop" style="float:right;"/>
</div>
