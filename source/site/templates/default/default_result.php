<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xius_result" id="xius_result"><a name="xiustop"></a>
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">
<?php
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
<a href="#xiustop" style="float:right;"><img src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" /></a>
</div>
