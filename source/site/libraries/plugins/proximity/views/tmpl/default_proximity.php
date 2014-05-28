<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>

			<div class="p-add-address">
			<form action="#" onsubmit="addAddressToMap<?php echo $this->data['id']; ?>(); return false;"><h3>
			<?php echo XiusText::_('SET_COORDINATES_BY_ADDRESS'); ?>
			<input type="text" name="xiusAddressNameEl<?php echo $this->data['id']; ?> " id="xiusAddressEl<?php echo $this->data['id']; ?>" value="" class="address_input" size="30" />
			<input type="submit" name="find" value="<?php echo XiusText::_('SET'); ?>" />
			</h3></form>
			</div>
		
		<div id="xiusmaps"><div><form action="#" name="xiusGmapForm">		
		<?php
		
	/*	if ($ttype == 'marker') {
			$this->map->loadCoordinatesJS();
			} */
				
		 	$this->map->loadAPI(); 
		?>
				
		<div align="center" style="margin:0;padding:0">
		<div id="xiusMap<?php echo $this->data['id']; ?>" style="margin:0;padding:0;width:<?php echo $this->data['width']; ?>px;height:<?php echo $this->data['hight']; ?>px"></div></div>

		<?php 
		echo  $this->map->startJScData();
	
		echo $this->map->addAjaxAPI('maps', '3.x', '{"other_params":"sensor=false"}');
		echo $this->map->addAjaxAPI('search', '1');

		echo $this->map->createMap('xiusMap', 'mapXiusMap', 'xiusLatLng', 'xiusOptions','tstXiusMap', 'tstIntXiusMap', 'xiusGeoCoder', TRUE);
		echo $this->map->cancelEventFunction();
		echo $this->map->checkMapFunction();
	
		echo $this->map->startMapFunction();
		
		echo $this->map->setLatLng( $this->data['latitude'],$this->data['longitude'] );
		echo $this->map->startMapOptions();
		echo $this->map->setMapOption('zoom', $this->data['zoom']).','."\n";
		echo $this->map->setCenterOpt().','."\n";
		echo $this->map->setTypeControlOpt().','."\n";
		echo $this->map->setNavigationControlOpt().','."\n";
		echo $this->map->setMapOption('scaleControl', 1, true).','."\n";
		echo $this->map->setMapOption('scrollwheel', 1).','."\n";
		echo $this->map->setMapOption('disableDoubleClickZoom', 0).','."\n";
		//	echo $this->map->setMapOption('googleBar', map->googlebar).','."\n";// Not ready yet
		//	echo $this->map->setMapOption('continuousZoom', map->continuouszoom).','."\n";// Not ready yet
		echo $this->map->setMapTypeOpt()."\n";
		echo $this->map->endMapOptions();
		echo $this->map->setMap();
		require_once XIUS_PLUGINS_PATH.DS.'proximity'.DS.'googlemaphelper.php';
		//echo $this->map->exportZoom(zoom, 'document.forms.xiusGmapForm.elements.zoom');
		echo $this->map->exportMarker('Global', $this->data['type'], $this->data['latitude'], $this->data['longitude'], "window.top.document.forms.$this->formName.elements.$this->latitudeEle", "window.top.document.forms.$this->formName.elements.$this->longitudeEle");
		echo $this->map->setListener();
		echo $this->map->setGeoCoder();
		echo $this->map->endMapFunction();

		echo $this->map->addAddressToMapFunction('Global', 'xiusAddressEl', $this->data['type'], "window.top.document.forms.$this->formName.elements.$this->latitudeEle", "window.top.document.forms.$this->formName.elements.$this->longitudeEle");// no '.id.' - it is set in class

		echo $this->map->setInitializeFunction();
	
		echo $this->map->endJScData();   	
		echo XiusText::_("MESSAGE_ON_MAP"); 
		?>
		</form>
		</div>
	</div>
<?php 
