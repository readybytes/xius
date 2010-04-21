<form action="index.php?option=com_xius&view=search&task=basicsearch" method="post">
<?php

/*XITODO : pass variable for color */
$css = JURI::base().'administrator/components/com_xius/assets/css/front/blue.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
include('toolbar.php');
include('sorting.php');
include('userlisting.php');
include('pagination.php');
?>	

<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="search" />
	<input type="hidden" name="task" value="basicsearch" />
</form>
