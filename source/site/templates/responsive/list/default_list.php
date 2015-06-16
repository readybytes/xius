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
<style>
#xiusListName {
	padding:2px;
	font-style: italic;
	font-weight: bold;
}
</style>

<span id = "xiusListName">
<?php 
$listid = 0;
// XITODO : cleanup code
if(!empty( $this->list ))	:
	$listid = $this->list->id;
	if(empty($this->list->name)):
		$name = 'LIST'.$listid;
	else :
		$name = $this->list->name;
	endif;
		
	echo $name;

endif;
?>
</span>
<input type="hidden" name="listid" value="<?php echo $listid;?>" />
<?php 
echo $this->loadTemplate('result');