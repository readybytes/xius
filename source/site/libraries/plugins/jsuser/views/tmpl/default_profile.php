<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(JFactory::getApplication()->isAdmin()){
 $value = $this->value;
}
?>
<select id="profileType" name="profileType">
<option> <?php echo XiusText::_("SELECT_PROFILETYPE");?></option> 
<?php 
	$profileTypes = $this->profileTypes;
	foreach($profileTypes as $profileType ){?>
    	<option value = "<?php echo $profileType->id;?>"
        <?php echo (isset($this->value) && $profileType->id == $this->value)?"selected=selected":""; ?>>
        <?php echo $profileType->name;?></option>
<?php }?>
</select>
<?php ?>