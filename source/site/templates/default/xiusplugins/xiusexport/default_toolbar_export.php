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

<img 
	src='<?php echo JURI::base()."components/com_xius/assets/images/excel.png";?>'
	onClick="location.href='<?php echo $this->url; ?>'" 
	title='<?php echo XiusText::_('EXPORT_TO_CSV'); ?>' 
/>
<?php 