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
		<div id="xiusProxiMap">
      		<input type="hidden" id="<?php echo $this->data['elePrefix'];?>_option" name="<?php echo $this->data['elePrefix'];?>_option" value="googlemap"/> 
      		  	   	
		  		<a id="<?php echo $this->buttonMap->modalname ;?>" 
		  			class="<?php echo $this->buttonMap->modalname ;?>"
		  			title="<?php echo $this->buttonMap->text ; ?>" 
		  			href="<?php echo $this->buttonMap->link ;?>"
		  			rel="<?php  echo $this->buttonMap->options ;?>"  >
					<?php echo XiusText::_("MAP"); ?>
			  		<?php //echo $this->buttonMap->text ;?>
		  		</a>

		  		<input  type="hidden" name="<?php echo $this->data['elePrefix'];?>_dummy"
 					 	id="<?php echo $this->data['elePrefix'];?>_dummy" 
 					 	value=""
						/>
		</div>
<?php 