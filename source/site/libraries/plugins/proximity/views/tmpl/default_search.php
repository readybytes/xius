<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

		//XITODO:: cleanup code
		$elePrefix	= $this->data['elePrefix'];
		$location	= $this->data['location'];
		$defaultLat	= $this->data['configLat'];
		$defaultLong= $this->data['configLong'];
		$latitude	= ($location=='mylocation')?$this->data['latitude']:$defaultLat;
		$longitude	= ($location=='mylocation')?$this->data['longitude']:$defaultLong;
		$userId		= $this->data['userId']
?>
      <div>
      <div class="xiusleft">
      	<input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusShowGoogleMap(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $defaultLat ?>&quot;, &quot;<?php echo $defaultLong; ?>&quot;);" value="googlemap"  <?php echo ($location=='googlemap')? "checked": "" ;?> /> 
      		<?php echo XiusText::_('XIUS_MAP'); ?>
      </div><div class="xiusleft">
      	<input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusShowAddressBox(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $defaultLat ?>&quot;, &quot;<?php echo $defaultLong; ?>&quot;);" value="addressbox" <?php echo $location; ?> <?php echo ($location=='addressbox')? "checked": "" ;?> />
      		<?php echo XiusText::_('XIUS_ADDRESS'); ?>  
      </div><div class="xiusleft">
      	 <input type="radio" id="<?php echo $elePrefix; ?>_option" name="<?php echo $elePrefix; ?>_option" onClick="javascript:xiusAddMyLocation(this,&quot;<?php echo $elePrefix; ?>&quot;,&quot;<?php echo $this->data['latitude'] ?>&quot;, &quot;<?php echo $this->data['longitude']; ?>&quot;);" value="mylocation" <?php echo $location; ?> <?php echo ($location=='mylocation')? "checked": "" ;?> <?php echo ($userId == 0) ? "disabled" : ""; ?>/>
      			<?php echo XiusText::_('XIUS_PROXIMITY_MY_LOCATION'); ?>
      </div>
      </div>
            
      <div id="<?php echo $elePrefix; ?>_gmap_option" style="<?php echo "display:".(($location=='googlemap')? "block": "none;")?>;">
		  <a id="<?php echo $this->buttonMap->modalname; ?>" class="<?php echo $this->buttonMap->modalname; ?>" title="<?php echo $this->buttonMap->text; ?>" href="<?php echo $this->buttonMap->link; ?>" rel="<?php echo $this->buttonMap->options; ?>"><?php echo $this->buttonMap->text; ?></a>
	  </div>

	  <div id="<?php echo $elePrefix; ?>_address_option" style="<?php echo "display:".(($location=='addressbox')? "block": "none;")?>;">
         <div class="xiusProximityLabel"><?php echo XiusText::_('ADDRESS'); ?></div>
         <div><input type="text" name="<?php echo $elePrefix; ?>_address" id="<?php echo $elePrefix; ?>_address"></div>
      </div>
      
      <input class="inputbox" type="hidden" name="<?php echo $elePrefix; ?>_lat" id="<?php echo $elePrefix; ?>_lat" value=<?php echo $latitude; ?> />
      <input class="inputbox" type="hidden" name="<?php echo $elePrefix; ?>_long" id="<?php echo $elePrefix; ?>_long" value=<?php echo $longitude; ?> />
      
      <div class="xiusProximityLabel xiusleft">
      	<?php echo XiusText::_('DISTANCE'); ?>
		<input  class="xiusProximityInputbox" 
				type="text" size="12" 
				name="<?php echo $elePrefix; ?>_dis" 
				id="<?php echo $elePrefix; ?>_dis" 
				value="<?php echo $this->data['configDist']; ?>" />

	   <select 
				class="xiusProximitySelectbox" 
				name="<?php echo $elePrefix; ?>_dis_unit" 
				id="<?php echo $elePrefix; ?>_dis_unit">
			   		<option value="miles" <?php echo ($this->data['configUnit']== 'miles') ? "SELECTED" : "" ; ?> >
        		    	<?php echo XiusText::_("MILES"); ?> </option>
	      	   		<option value="kms" <?php echo ($this->data['configUnit']== 'kms') ? "SELECTED" : "" ; ?> >
    	  	   			<?php echo XiusText::_("KMS"); ?> </option>
	   </select>
      </div>
<?php 
