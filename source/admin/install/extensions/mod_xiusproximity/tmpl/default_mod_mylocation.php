<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>
<div id="xiusProxiLocation">
					<input 
						type="hidden" 
						id="<?php echo $this->data['elePrefix'];?>_option"
						name="<?php echo $this->data['elePrefix'];?>_option"
						value="mylocation"  />
						<input type="hidden" name="<?php echo $this->data['elePrefix'];?>_dummy"
 					 	id="<?php echo $this->data['elePrefix'];?>_dummy" 
 					 	value=""/>
      				<?php echo XiusText::_('XIUS_PROXIMITY_MY_LOCATION');?>
		</div>
<?php
 