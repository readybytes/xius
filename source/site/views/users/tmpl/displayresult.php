<form action="index.php?option=com_xius&view=users&suplytask=displayresult" name="userForm" id="userForm" method="post">
<?php

/*XITODO : pass variable for color */
$css = JURI::base().'administrator/components/com_xius/assets/css/front/blue.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
if($this->task == 'displayList')
	include('listinfo.php');
	
include('appliedinfo.php');
include('availableinfo.php');
?>
<div><div class="xius_bar">
<?php 
include('toolbar.php');
include('sorting.php');
?>
</div></div>
<div class="clr"></div>
<?php
include('userlisting.php');
include('pagination.php');
?>	
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="<?php echo $this->task;?>" />
<input type="hidden" name="subtask" value="<?php echo $this->subtask;?>" />
<input type="hidden" name="scanned" value="1" />
</form>
