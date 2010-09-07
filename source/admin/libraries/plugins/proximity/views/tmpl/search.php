<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
?> 
<?php 
		//XITODO:: cleanup code
		$elePrefix	= $this->data['elePrefix'];
		$location	= $this->data['location'];
		$defaultLat	= $this->data['configLat'];
		$defaultLong= $this->data['configLong'];
		$latitude	= ($location=='mylocation')?$this->data['latitude']:$defaultLat;
		$longitude	= ($location=='mylocation')?$this->data['longitude']:$defaultLong;
?>
      <div>
      	<input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusShowGoogleMap(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $defaultLat ?>&quot;, &quot;<?php echo $defaultLong; ?>&quot;);" value="googlemap"  <?php echo ($location=='googlemap')? "checked": "" ;?> /> 
      		<?php echo JText::_('XIUS MAP'); ?>
      	<input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusShowAddressBox(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $defaultLat ?>&quot;, &quot;<?php echo $defaultLong; ?>&quot;);" value="addressbox" <?php echo $location; ?> <?php echo ($location=='addressbox')? "checked": "" ;?> />
      		<?php echo JText::_('XIUS ADDRESS'); ?>
      	 <input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusAddMyLocation(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $this->data['latitude'] ?>&quot;, &quot;<?php echo $this->data['longitude']; ?>&quot;);" value="mylocation" <?php echo $location; ?> <?php echo ($location=='mylocation')? "checked": "" ;?> />
      			<?php echo JText::_('XIUS PROXIMITY MY LOCATION'); ?>
      </div>
            
      <div id="<?php echo $elePrefix; ?>_gmap_option" style="<?php echo "display:".(($location=='googlemap')? "block": "none;")?>;">
		  <a id="<?php echo $this->buttonMap->modalname; ?>" class="<?php echo $this->buttonMap->modalname; ?>" title="<?php echo $this->buttonMap->text; ?>" href="<?php echo $this->buttonMap->link; ?>" rel="<?php echo $this->buttonMap->options; ?>"><?php echo $this->buttonMap->text; ?></a>
	  </div>

	  <div id="<?php echo $elePrefix; ?>_address_option" style="<?php echo "display:".(($location=='addressbox')? "block": "none;")?>;">
         <div class="xiusProximityLabel"><?php echo JText::_('ADDRESS'); ?></div>
         <div><input type="text" name="<?php echo $elePrefix; ?>_address" id="<?php echo $elePrefix; ?>_address"></div>
      </div>
      
      <input class="inputbox" type="hidden" name="<?php echo $elePrefix; ?>_lat" id="<?php echo $elePrefix; ?>_lat" value=<?php echo $latitude; ?> />
      <input class="inputbox" type="hidden" name="<?php echo $elePrefix; ?>_long" id="<?php echo $elePrefix; ?>_long" value=<?php echo $longitude; ?> />
      
      <div class="xiusProximityLabel"><?php echo JText::_('DISTANCE'); ?></div>
      
      <div><input class="xiusProximityInputbox" type="text" size="12" name="<?php echo $elePrefix; ?>_dis" id="<?php echo $elePrefix; ?>_dis" value="10" />
		   <select class="xiusProximitySelectbox" name="<?php echo $elePrefix; ?>_dis_unit" id="<?php echo $elePrefix; ?>_dis_unit" >
        		<option value="miles" selected><?php echo JText::_("MILES"); ?></option>
      	   		<option value="kms" ><?php echo JText::_("KMS"); ?></option>
		   </select>
      </div>
<?php 
