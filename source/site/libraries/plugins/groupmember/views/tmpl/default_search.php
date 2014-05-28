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
<select id="group" name="group">
	   <option> <?php echo XiusText::_("SELECT_GROUP");?></option>
	<?php 
	$groups = $this->groups;
	foreach($groups as $group ){?>
    	<option value = "<?php echo $group->id;?>" > <?php echo $group->name;?></option>
    <?php 
	}
    ?>

</select>
<?php
