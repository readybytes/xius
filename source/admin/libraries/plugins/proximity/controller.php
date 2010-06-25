<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(dirname(__FILE__) . DS . 'defines.php');

class XiusPluginControllerProximity extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
		
		//registering some extra in all task list which we want to call
		//$this->registerTask( 'reset' , 'reset' );
	}
	
    function display() 
	{
		parent::display();
    }
    
    function getLocationMap($pluginId=null)
    {   	
    	require_once( dirname(__FILE__) . DS . 'googlemaphelper.php' );
    	// use default
   		if($pluginId === null)
    		$pluginId = JRequest::getVar('pluginid',0,'GET');
    	
    	$formName	= JRequest::getVar('fromFormName','userForm','GET');
    	$instance 	= XiusFactory::getPluginInstanceFromId($pluginId);
    	if(!$instance)
    		return false;
    		
    	$latitude 	= $instance->get('pluginType').$instance->get('key').'_lat';
    	$longitude	= $instance->get('pluginType').$instance->get('key').'_long';
    	
    	$this->latitude 	= PROXIMITY_DEAFULT_LAT_LOC;
    	$this->longitude	= PROXIMITY_DEAFULT_LONG_LOC;
    	$this->type			= PROXIMITY_DEAFULT_MAP_TYPE;
    	$this->zoom			= PROXIMITY_DEAFULT_MAP_ZOOM;
    	
    	$id		= '';
    	echo '</form></div><div class="p-add-address">'
			. '<form action="#" onsubmit="addAddressToMap'.$id.'(); return false;"><h3>'
			. JText::_('Set Coordinates by address').' : '
			. '<input type="text" name="xiusAddressNameEl'.$id.'" id="xiusAddressEl'.$id.'" value="" class="address_input" size="30" />'
			. '<input type="submit" name="find" value="'. JText::_('Set').'" />'
			. '</h3></form>'
			. '</div>';
		echo '</div>';	
		
		echo '<div id="xiusmaps"><div><form action="#" name="xiusGmapForm">';
		
		$map	= new XiusGmap($id);
		if ($this->type == 'marker') {
			$map->loadCoordinatesJS();
		}
		$map->loadAPI();
		echo '<div align="center" style="margin:0;padding:0">';
		echo '<div id="xiusMap'.$id.'" style="margin:0;padding:0;width:'.PROXIMITY_MAP_WIDTH.'px;height:'.PROXIMITY_MAP_HEIGHT.'px"></div></div>';

		echo $map->startJScData();
	
		echo $map->addAjaxAPI('maps', '3.x', '{"other_params":"sensor=false"}');
		echo $map->addAjaxAPI('search', '1');

		echo $map->createMap('xiusMap', 'mapXiusMap', 'xiusLatLng', 'xiusOptions','tstXiusMap', 'tstIntXiusMap', 'xiusGeoCoder', TRUE);
		echo $map->cancelEventFunction();
		echo $map->checkMapFunction();
	
		echo $map->startMapFunction();
		
		echo $map->setLatLng( $this->latitude, $this->longitude );
		echo $map->startMapOptions();
		echo $map->setMapOption('zoom', $this->zoom).','."\n";
		echo $map->setCenterOpt().','."\n";
		echo $map->setTypeControlOpt().','."\n";
		echo $map->setNavigationControlOpt().','."\n";
		echo $map->setMapOption('scaleControl', 1, true).','."\n";
		echo $map->setMapOption('scrollwheel', 1).','."\n";
		echo $map->setMapOption('disableDoubleClickZoom', 0).','."\n";
		//	echo $map->setMapOption('googleBar', $this->map->googlebar).','."\n";// Not ready yet
		//	echo $map->setMapOption('continuousZoom', $this->map->continuouszoom).','."\n";// Not ready yet
		echo $map->setMapTypeOpt()."\n";
		echo $map->endMapOptions();
		echo $map->setMap();
		
		//echo $map->exportZoom($this->zoom, 'document.forms.xiusGmapForm.elements.zoom');
		echo $map->exportMarker('Global', $this->type, $this->latitude, $this->longitude, "window.top.document.forms.$formName.elements.$latitude", "window.top.document.forms.$formName.elements.$longitude");
		echo $map->setListener();
		echo $map->setGeoCoder();
		echo $map->endMapFunction();

		echo $map->addAddressToMapFunction('Global', 'xiusAddressEl', $this->type, "window.top.document.forms.$formName.elements.$latitude", "window.top.document.forms.$formName.elements.$longitude");// no '.id.' - it is set in class

		echo $map->setInitializeFunction();
	
		echo $map->endJScData();   	
		echo JText::_("MESSAGE ON MAP");
    }
}
