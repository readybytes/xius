<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>	
		<div id="xiusProxiMap">
      		<input type="hidden" id="<?php echo $this->data['elePrefix'];?>_option" name="<?php echo $this->data['elePrefix'];?>_option" value="googlemap"/> 
      		  	   	
		  		<a id="<?php echo $this->buttonMap->modalname ;?>" 
		  			class="<?php echo $this->buttonMap->modalname ;?>"
		  			title="<?php echo $this->buttonMap->text ; ?>" 
		  			href="<?php echo $this->buttonMap->link ;?>"
		  			rel="<?php  echo $this->buttonMap->options ;?>"  >
	
			  		<?php echo $this->buttonMap->text ;?>
		  		</a>

		  		<input  type="hidden" name="<?php echo $this->data['elePrefix'];?>_dummy"
 					 	id="<?php echo $this->data['elePrefix'];?>_dummy" 
 					 	value=""
						/>
		</div>
<?php 