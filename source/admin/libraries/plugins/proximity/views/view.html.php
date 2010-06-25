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
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		
		 
		$linkMap = "index.php?option=com_xius&task=getLocationMap&plugin=proximity&pluginid=".$calleObject->get('id')."&tmpl=component";
		JHTML::_('behavior.modal', 'a.modal-button');
		$buttonMap = new JObject();
		$buttonMap->set('modal', true);
		$buttonMap->set('link', $linkMap);
		$buttonMap->set('text', JText::_( 'SET LOCATION' ));
		$buttonMap->set('name', 'image');
		$buttonMap->set('modalname', 'modal-button');
		$buttonMap->set('options', "{handler: 'iframe', size: {x: ".PROXIMITY_IFRAME_WIDTH.", y: ".PROXIMITY_IFRAME_HEIGHT."}}");
		$this->assignRef('buttonmap', $buttonMap);
		
		$fieldHtml 	= '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'.$buttonMap->text.'</a><br/>';
		//$fieldHtml  = '<a href="index.php?option=com_xius&plugin=proximity&task=getLocationMap&tmpl=component" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_map" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_map">'.JText::_("GET LOCATION").'</a>';
		$fieldHtml .= JText::_('LATITUDE').'&nbsp; &nbsp; &nbsp;<input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_lat" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_lat" value="" /><br /> ';
		$fieldHtml .= JText::_('LONGITUDE').' <input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_long" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_long" value="" /><br />'; 
		$fieldHtml .= JText::_('DISTANCE').'&nbsp;&nbsp; <input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_dis" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_dis" value="" />';
		$fieldHtml .= '<select class="selectbox" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_dis_unit" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_dis_unit" value="">';
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
