<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

		//XITODO:: cleanup code

		$moduleParam= ModXiusProximity::setModuleParams();
		$location	= $moduleParam->get('xius_proximity_params','googlemap');
		$latitude	= ($location=='mylocation')?$this->data['latitude']:$this->data['configLat'];
		$longitude	= ($location=='mylocation')?$this->data['longitude']:$this->data['configLong'];
		$elePrefix	= $this->data['elePrefix'];
		$userId		= $this->data['userId']	;
?>

	<input type="hidden" name="<?php echo $elePrefix;?>_lat"
	 						id="<?php echo $elePrefix ;?>_lat"
	 						value="<?php echo $latitude;?>" />
	<input type="hidden" name="<?php echo $elePrefix;?>_long"
	 					 	id="<?php echo $elePrefix;?>_long"
	 					 	value="<?php echo $longitude;?>"/>

	<div class="float-left">
		<?php echo XiusText::_('WITHIN');?>
		<input type="text" name="<?php echo $elePrefix;?>_dis"
								id="xiusDistanceInput"
								value="10" />
		
		<input 	name="<?php echo $elePrefix;?>_dis_unit" id="xiusDistance" 
				value="<?php echo $moduleParam->get('xius_distance','miles');?>" readonly="readonly" /> 
	</div>
	
	<div class="float-left">
		<div class="float-left">
			<?php echo XiusText::_('FROM'); ?>
		</div> 
		<?php echo $this->loadTemplate('mod_'.$location); ?>
	</div>


<?php 
