<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

if(empty($this->info))
	return false;
else if(!empty($this->info)){?>
	<select class="select" id="rawdata" name="rawdata">
	<?php 
	foreach($this->info as $k => $v){?>
    	<option value = "<?php echo $k;?>"><?php echo JText::_($v);?></option>
    <?php 
	}
    ?>
	
	</select>
	<?php 
}
				