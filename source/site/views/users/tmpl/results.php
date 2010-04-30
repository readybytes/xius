<form action="index.php?option=com_xius&view=users&suplytask=displayresult" name="userForm" id="userForm" method="post">
<?php

/*XITODO : pass variable for color */
$css = JURI::base().'components/com_xius/assets/css/blue.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
if($this->task == 'displayList')
	echo $this->loadTemplate('listinfo');
	
echo $this->loadTemplate('appliedinfo');
echo $this->loadTemplate('availableinfo');
//include('appliedinfo.php');
//include('availableinfo.php');
?>
<div><div class="xius_bar">
<?php 
echo $this->loadTemplate('toolbar');
echo $this->loadTemplate('sorting');
?>
</div></div>
<div class="clr"></div>
<?php
echo $this->loadTemplate('userlisting');
echo $this->loadTemplate('pagination');
//include('userlisting.php');
//include('pagination.php');
?>	
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="users" />
<input type="hidden" name="task" value="<?php echo $this->task;?>" />
<input type="hidden" name="subtask" value="" />
<input type="hidden" name="scanned" value="1" />
</form>
