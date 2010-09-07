<?php

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class RangesearchView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$this->setLayout('search');
		
		$value0 = '';
		$value1 = '';
  		
 		if(is_array($value)){
 			$value0 = $value[0];
 			$value1 = $value[1];
 		}
 			 		
		$params		=	$calleObject->get('pluginParams');
		$pluginType	=	$calleObject->get('pluginType');
		$key		=	$calleObject->get('key');		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
 		if(JString::strtolower($params->get('rangesearchType', 'date')) === 'date-range'){
			JHTML::_('behavior.calendar');
            $fieldHtml	 = JText::_('RANGESEARCH FROM').'<br/>'.JHTML::_('calendar', $value0, 'field'.$pluginType.$key.'_min', 'field'.$pluginType.$key.'_min', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19')).'<br />';
			$fieldHtml	.= JText::_('RANGESEARCH TO').'<br/>'.JHTML::_('calendar', $value1, 'field'.$pluginType.$key.'_max', 'field'.$pluginType.$key.'_max', '%d-%m-%Y', array('class'=>'inputbox', 'size'=>'25',  'maxlength'=>'19'));
      		}
		else{
			$fieldHtml	 = JText::_('RANGESEARCH FROM').'<br/><input class="inputbox" type="text" name="'.$pluginType.$key.'_min" id="'.$pluginType.$key.'_min" value="'.$value0.'" /><br />'; 
			$fieldHtml	.= JText::_('RANGESEARCH TO').'<br/><input class="inputbox" type="text" name="'.$pluginType.$key.'_max" id="'.$pluginType.$key.'_max" value="'.$value1.'" />';			
			}
		
		$this->assign('fieldHtml',$fieldHtml);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		
		return $contents;
	}
	
}
