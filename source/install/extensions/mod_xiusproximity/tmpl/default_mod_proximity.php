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

		$moduleParam= ModXiusProximity::setModuleParams();
		$location	= $moduleParam->get('xius_proximity_params','map');
		$latitude	= ($location=='mylocation')?$this->data['latitude']:$this->data['configLat'];
		$longitude	= ($location=='mylocation')?$this->data['longitude']:$this->data['configLong'];
		$elePrefix	= $this->data['elePrefix'];
		$userId		= $this->data['userId']	;

		echo $this->loadTemplate('mod_'.$location);

		?>
<input type="hidden" name="<?php echo $elePrefix;?>_lat"
 						id="<?php echo $elePrefix ;?>_lat"
 						value="<?php echo $latitude;?>" />
<input type="hidden" name="<?php echo $elePrefix;?>_long"
 					 	id="<?php echo $elePrefix;?>_long"
 					 	value="<?php echo $longitude;?>"/>
			 	
<div id="xiusProxiDistance">      
<?php echo XiusText::_('WITHIN');?>
<input type="text" name="<?php echo $elePrefix;?>_dis"
						id="xiusDistanceInput"
						value="10" />
<input name="<?php echo $elePrefix;?>_dis_unit" id="xiusDistance" 
value="<?php echo $moduleParam->get('xius_distance','miles');?>" readonly="readonly" /></div>
<?php 

