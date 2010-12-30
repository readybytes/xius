<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

if(empty($this->info))
	return false;
?>
	<select id="rawdata" name="rawdata">
		<?php foreach($this->info as $k => $v) :?>
		<option 	value = "<?php echo $k;?>"> 
				<?php echo XiusText::_($v);?>
			</option>
		<?php endforeach; ?>
	</select>
<?php 
