<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
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