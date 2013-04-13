<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>

<img 
	src='<?php echo JURI::base()."components/com_xius/assets/images/excel.png";?>'
	onClick="location.href='<?php echo $this->url; ?>'" 
	title='<?php echo XiusText::_('EXPORT_TO_CSV'); ?>' 
/>
<?php 