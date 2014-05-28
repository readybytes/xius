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

<a id="<?php echo $this->buttonMap->modalname.$this->userId; ?>" class="<?php echo $this->buttonMap->modalname; ?>" title="<?php echo $this->buttonMap->text; ?>" href="<?php echo $this->buttonMap->link; ?>" rel="<?php echo $this->buttonMap->options; ?>">
     <?php echo XiusText::_('EMAIL'); ?>
     </a>

<?php 
