<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?>        
      <div>
      	<input type="radio" id="<?php echo $this->data['elePrefix']; ?>_option" name="<?php echo $this->data['elePrefix']; ?>_option" onClick="javascript:xiusShowGoogleMap(this,&quot;<?php echo $this->data['elePrefix']; ?>&quot;);" value="googlemap" /> 
      		<?php echo JText::_('XIUS MAP'); ?>
      	<input type="radio" id="<?php echo $this->data['elePrefix']; ?>_option" name="<?php echo $this->data['elePrefix']; ?>_option" onClick="javascript:xiusShowAddressBox(this,&quot;<?php echo $this->data['elePrefix']; ?>&quot;);" value="addressbox" />
      		<?php echo JText::_('XIUS ADDRESS'); ?>
      </div>
            
      <div id="<?php echo $this->data['elePrefix']; ?>_gmap_option" style="display:none;">
		  <a id="<?php echo $this->buttonMap->modalname; ?>" class="<?php echo $this->buttonMap->modalname; ?>" title="<?php echo $this->buttonMap->text; ?>" href="<?php echo $this->buttonMap->link; ?>" rel="<?php echo $this->buttonMap->options; ?>"><?php echo $this->buttonMap->text; ?></a>
	  </div>

	  <div id="<?php echo $this->data['elePrefix']; ?>_address_option" style="display:none;">
         <div class="xiusProximityLabel"><?php echo JText::_('ADDRESS'); ?></div>
         <div><input type="text" name="<?php echo $this->data['elePrefix']; ?>_address" id="<?php echo $this->data['elePrefix']; ?>_address"></div>
      </div>
      
      <input class="inputbox" type="hidden" name="<?php echo $this->data['$elePrefi']; ?>_lat" id="<?php echo $this->data['elePrefix']; ?>_lat" value=<?php echo $this->data['latitude']; ?> />
      <input class="inputbox" type="hidden" name="<?php echo $this->data['elePrefix']; ?>_long" id="<?php echo $this->data['elePrefix']; ?>_long" value=<?php echo $this->data['longitude']; ?> />
      
      <div class="xiusProximityLabel"><?php echo JText::_('DISTANCE'); ?></div>
      
      <div><input class="xiusProximityInputbox" type="text" size="12" name="<?php echo $this->data['elePrefix']; ?>_dis" id="<?php echo $this->data['elePrefix']; ?>_dis" value="10" />
		   <select class="xiusProximitySelectbox" name="<?php echo $this->data['elePrefix']; ?>_dis_unit" id="<?php echo $this->data['elePrefix']; ?>_dis_unit" >
        		<option value="miles" selected><?php echo JText::_("MILES"); ?></option>
      	   		<option value="kms" ><?php echo JText::_("KMS"); ?></option>
		   </select>
      </div>
<?php 
