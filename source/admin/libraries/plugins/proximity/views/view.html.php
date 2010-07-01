<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(dirname(__FILE__) . DS . '..' .DS . 'defines.php');
require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

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
           
        $this->setLayout('search');
       
        $latitude 	= XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLat',28.635308);
    	$longitude	= XiusHelpersUtils::getConfigurationParams('xiusProximityDefaultLong',77.22496);
    	
        
        
        /*In $this->key , I will store field id for my understanding
         * so i can easily get properties of info
         */
        // add js file
        $js = JURI::base().'administrator/components/com_xius/assets/js/proximity.js';
        $document =& JFactory::getDocument();
        $document->addScript($js);
        
        $mySess 	= & JFactory::getSession();
		$formName	= $mySess->get('xiusModuleForm','userForm','XIUS');
       		
        $elePrefix  = $calleObject->get('pluginType').$calleObject->get('key')."_$formName";
        $fieldHtml  = '';
        $fieldHtml .= '<input type="radio" id="'.$elePrefix.'_option" name="'.$elePrefix.'_option" onClick="javascript:xiusShowGoogleMap(this,&quot;'.$elePrefix.'&quot;);" value="googlemap" />Google Map';
        $fieldHtml .= '<input type="radio" id="'.$elePrefix.'_option" name="'.$elePrefix.'_option" onClick="javascript:xiusShowAddressBox(this,&quot;'.$elePrefix.'&quot;);" value="addressbox" />Address Box';
         
        $linkMap = "index.php?option=com_xius&task=getLocationMap&&fromFormName=$formName&plugin=proximity&pluginid=".$calleObject->get('id')."&tmpl=component";
        JHTML::_('behavior.modal', 'a.'.$elePrefix.'_map_button');
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('link', $linkMap);
        $buttonMap->set('text', JText::_( 'SHOW GOOGLE MAP' ));
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', $elePrefix.'_map_button');
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".PROXIMITY_IFRAME_WIDTH.", y: ".PROXIMITY_IFRAME_HEIGHT."}}");
        $this->assignRef('buttonmap', $buttonMap);
        $fieldHtml    .= '<div id="'.$elePrefix.'_gmap_option" style="display:none;">';
        $fieldHtml     .= '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'.$buttonMap->text.'</a></div>';
       
        $fieldHtml    .= '<div id="'.$elePrefix.'_address_option" style="display:none;">'.JText::_('ADDRESS').'&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="'.$elePrefix.'_address" id="'.$elePrefix.'_address"></div>';
        
       // $fieldHtml .= JText::_('LATITUDE').'&nbsp; &nbsp; &nbsp;<input class="inputbox" type="text" name="'.$elePrefix.'_lat" id="'.$elePrefix.'_lat" value='.$latitude.' /> ';
       // $fieldHtml .= JText::_('LONGITUDE').' <input class="inputbox" type="text" name="'.$elePrefix.'_long" id="'.$elePrefix.'_long" value='.$longitude.' /><br />';
        $fieldHtml 	 .= '<input class="inputbox" type="hidden" name="'.$elePrefix.'_lat" id="'.$elePrefix.'_lat" value='.$latitude.' /> ';
        $fieldHtml   .= '<input class="inputbox" type="hidden" name="'.$elePrefix.'_long" id="'.$elePrefix.'_long" value='.$longitude.' /><br />';
        $fieldHtml .= JText::_('DISTANCE').'&nbsp;&nbsp; <input class="inputbox" type="text" name="'.$elePrefix.'_dis" id="'.$elePrefix.'_dis" value="10" />';
        $fieldHtml .= '<select class="selectbox" name="'.$elePrefix.'_dis_unit" id="'.$elePrefix.'_dis_unit" value="">';
        $fieldHtml .= '<option value="miles" selected>'.JText::_("MILES").'</option>';
        $fieldHtml .= '<option value="kms" >'.JText::_("KMS").'</option></select>';
                   
        //print_r($fieldHtml);
        $this->assign('fieldHtml',$fieldHtml);
       
        ob_start();
        $this->display();
        $contents = ob_get_clean();
       
        return $contents;
    }   
}
