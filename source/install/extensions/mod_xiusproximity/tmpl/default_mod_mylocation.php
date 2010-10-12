<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

?><div id="xiusProxiLocation">
					<input 
						type="hidden" 
						id="<?php echo $this->data['elePrefix'];?>_option"
						name="<?php echo $this->data['elePrefix'];?>_option"
						value="mylocation"  />
						<input type="hidden" name="<?php echo $elePrefix;?>_dummy"
 					 	id="<?php echo $elePrefix;?>_dummy" 
 					 	value=""/>
      				<?php echo XiusText::_('XIUS PROXIMITY MY LOCATION');?>
		</div>
<?php
 