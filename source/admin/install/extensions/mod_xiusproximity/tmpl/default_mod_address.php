<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
	<div id="xiusProxiAddress">
		          <input type="hidden" id=" <?php echo $this->data['elePrefix'];?>_option" name="<?php echo $this->data['elePrefix']; ?>_option" value="addressbox" />
      			  <?php //echo XiusText::_('XIUS ADDRESS')?>

      			  <input type="text" name="<?php echo $this->data['elePrefix']; ?>_address"  
      			  id="xiusAddress"  />
	</div>
<?php 