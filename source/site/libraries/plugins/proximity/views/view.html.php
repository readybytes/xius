<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once(dirname(__FILE__) . DS . '..' .DS . 'defines.php');
require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';
require_once XIUS_PLUGINS_PATH.DS.'proximity'.DS.'proximityhelper.php';

class ProximityView extends XiusBaseView
{
   
    function __construct()
    {
        parent::__construct(__FILE__);
    }
   
    function searchHtml($calleObject, $value = '')
    {
        if(!$calleObject->isAllRequirementSatisfy())
            return false;       
        
		$this->loadAssets('js','proximity.js');
        
        $data = array();
        $data['configLat']	 = $calleObject->get('pluginParams')->get('xiusProximityDefaultLat',28.635308);
    	$data['configLong']  = $calleObject->get('pluginParams')->get('xiusProximityDefaultLong',77.22496);
    	$data['configDist']	 = $calleObject->get('pluginParams')->get('xiusDefaultDistance',10);
    	$data['configUnit']  = $calleObject->get('pluginParams')->get('xiusDefaultDistanceUnit', XiusText::_("MILES"));
    	ProximityHelper::setUserLatLong($calleObject, $data);
        
    	$mySess 			 =  JFactory::getSession();
		$data['formName']	 = $mySess->get('xiusModuleForm','userForm','XIUS');
       	$data['elePrefix']   = $calleObject->get('pluginType').$calleObject->get('key')."_".$data['formName'];
		$data['location']    = $calleObject->get('pluginParams')->get('xius_default_location',"none");
       	
		$data['userId']	 =  JFactory::getUser()->id;
       
       	$linkMap = XiusRoute::_('index.php?option=com_xius&task=getLocationMap&fromFormName='.$data['formName'].'&plugin=proximity&pluginid='.$calleObject->get('id').'&tmpl=component');
    	$buttonMap = XiusFactory::getModalButtonObject($data['elePrefix'].'_map_button',XiusText::_('SHOW_GOOGLE_MAP') ,$linkMap,PROXIMITY_IFRAME_WIDTH,PROXIMITY_IFRAME_HEIGHT);

        $this->assignRef('buttonMap', $buttonMap);
	    $this->assignRef('data', $data);
   		
        ob_start();

		//XITODO : do use generic name, rmeove hardcoding, also generalize the code
    	// 	if module is asking for html
		if('mod_xiusproximity' === $mySess->get('xiusModuleName',false,'XIUS')){
	        $currentPath= $this->_path;			
			$this->addTemplatePath(JPATH_ROOT.DS.'modules'.DS.'mod_xiusproximity'.DS.'tmpl');
			$this->display('mod_proximity');

			$this->_path = $currentPath;
		}
		else
        	$this->display('search');
        	
        $contents = ob_get_clean();
        return $contents;
    }  
    
 	function getLocationMap($formName,$instance)
    {    	
    	require_once XIUS_PLUGINS_PATH.DS.'proximity'.DS.'googlemaphelper.php';
    	
    	$data=array();
    	$latitudeEle 		 = $instance->get('pluginType').$instance->get('key').'_'.$formName.'_lat';
    	$longitudeEle		 = $instance->get('pluginType').$instance->get('key').'_'.$formName.'_long';
    	   	
    	$data['latitude']	 = $instance->get('pluginParams')->get('xiusProximityDefaultLat',28.635308);
    	$data['longitude']	 = $instance->get('pluginParams')->get('xiusProximityDefaultLong',77.22496);
    	$data['type']		 = PROXIMITY_DEFAULT_MAP_TYPE;
    	$data['zoom']		 = $instance->get('pluginParams')->get('xiusProximityGmapZoom',PROXIMITY_DEFAULT_MAP_ZOOM);
    	$data['width']		 = PROXIMITY_MAP_WIDTH;
    	$data['hight']		 = PROXIMITY_MAP_HEIGHT;
    	$data['id']			 = '';
    	//XiTODO:: Why pass data_id 	
    	$map				 = new XiusGmap($data['id']);
    	
    	$this->assign('formName',$formName);
    	$this->assignRef('longitudeEle',$longitudeEle);
    	$this->assignRef('latitudeEle',$latitudeEle);
    	$this->assignRef( 'data', $data );
    	$this->assign('map',$map);
    	
    	return parent::display('proximity');
		
    } 
}
