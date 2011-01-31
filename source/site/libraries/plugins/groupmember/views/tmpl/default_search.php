<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if(!defined('_JEXEC')) die('Restricted access');

?>
<select id="group" name="group">
	   <option> <?php echo XiusText::_("SELECT_GROUP");?></option>
	<?php 
	$groups = $this->groups;
	foreach($groups as $group ){?>
    	<option value = "<?php echo $group->id;?>" > <?php echo XiusText::_($group->name);?></option>
    <?php 
	}
    ?>

</select>
<?php
