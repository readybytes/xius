<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

JHTML::_('behavior.mootools');

$this->loadAssets('css', 'result.css');
if($this->loadJquery){
	$this->loadAssets('js', 'jquery1.4.2.js');
	JFactory::getDocument()->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );
}
	
//XITODO : move to loadAssest function
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
<div class="pagination">
<?php echo $this->pagination->getPagesLinks();?>
</div>
</div>

<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="search" />
</form>
</div>