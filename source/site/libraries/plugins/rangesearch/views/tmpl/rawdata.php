<?php

if(!defined('_JEXEC')) die('Restricted access');

if(empty($this->info))
	return false;
else if(!empty($this->info)){?>
	<select id="rawdata" name="rawdata">
	<?php 
	foreach($this->info as $k => $v){?>
    	<option value = "<?php echo $k;?>"><?php echo XiusText::_($v);?></option>
    <?php 
	}
    ?>
	
	</select>
	<?php 
}