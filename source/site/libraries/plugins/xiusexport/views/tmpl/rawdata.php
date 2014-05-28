<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(empty($this->info))
	return false;
else if(!empty($this->info)){?>
	<select class="select" id="rawdata" name="rawdata">
	<?php 
	foreach($this->info as $k => $v){?>
    	<option value = "<?php echo $k;?>"><?php echo $v;?></option>
    <?php 
	}
    ?>
	
	</select>
	<?php 
}