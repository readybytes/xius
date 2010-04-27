<?php

/*XITODO : pass variable for color */
$css = JURI::base().'administrator/components/com_xius/assets/css/front/blue.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
include('sorting.php');
include('appliedInfo.php');
include('availableInfo.php');
include('userlisting.php');
include('pagination.php');
include('toolbar.php')
?>	
