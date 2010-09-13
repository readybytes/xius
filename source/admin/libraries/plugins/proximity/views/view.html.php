<?php

// no direct access
if(!defined('_JEXEC')) die('Restricted access');
require_once(dirname(__FILE__) . DS . '..' .DS . 'defines.php');
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'proximity'.DS.'proximityhelper.php';

class ProximityView extends XiusBaseView
{
   
    function __construct()
    {
        parent::__construct(__FILE__);
    }
   
    function searchHtml($calleObject)
    {
        if(!$calleObject->isAllRequirementSatisfy())
            return false;       
        
		$this->loadAssets('js','proximity.js');
        
        $data = array();
        $data['configLat']	 = XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLat',28.635308);
    	$data['configLong']  = XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLong',77.22496);
    	ProximityHelper::setUserLatLong($calleObject, $data);
        
    	$mySess 			= & JFactory::getSession();
		$data['formName']	= $mySess->get('xiusModuleForm','userForm','XIUS');
       	$data['elePrefix']  = $calleObject->get('pluginType').$calleObject->get('key')."_".$data['formName'];
		$data['location']   = $calleObject->get('pluginParams')->get('xius_default_location',"none");
       	
       
       	$linkMap = XiusRoute::_('index.php?option=com_xius&task=getLocationMap&fromFormName='.$data['formName'].'&plugin=proximity&pluginid='.$calleObject->get('id').'&tmpl=component');
    	$buttonMap = XiusFactory::getModalButtonObject($data['elePrefix'].'_map_button',XiusText::_( 'SHOW GOOGLE MAP' ),$linkMap,PROXIMITY_IFRAME_WIDTH,PROXIMITY_IFRAME_HEIGHT);

        $this->assignRef('buttonMap', $buttonMap);
	    $this->assignRef('data', $data);
   
        ob_start();
        $this->display('search');
        $contents = ob_get_clean();
        return $contents;
    }  
    
 	function getLocationMap($formName,$instance)
    {    	
    	require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'proximity'.DS.'googlemaphelper.php';
    	
    	$data=array();
    	$latitudeEle 		 = $instance->get('pluginType').$instance->get('key').'_'.$formName.'_lat';
    	$longitudeEle		 = $instance->get('pluginType').$instance->get('key').'_'.$formName.'_long';
    	   	
    	$data['latitude']	 = XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLat',28.635308);
    	$data['longitude']	 = XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLong',77.22496);
    	$data['type']		 = PROXIMITY_DEFAULT_MAP_TYPE;
    	$data['zoom']		 = PROXIMITY_DEFAULT_MAP_ZOOM;
    	$data['width']		 = PROXIMITY_MAP_WIDTH;
    	$data['hight']		 = PROXIMITY_MAP_HEIGHT;
    	$data['id']			 = '';
    	
    	$map				 = new XiusGmap($data['id']);
    	
    	$this->assign('formName',$formName);
    	$this->assignRef('longitudeEle',$longitudeEle);
    	$this->assignRef('latitudeEle',$latitudeEle);
    	$this->assignRef( 'data', $data );
    	$this->assign('map',$map);
    	
    	return parent::display('proximity');
		
    } 
}
