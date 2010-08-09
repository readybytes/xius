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

		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		$fieldHtml =JText::_('RANGESEARCH FROM').'<br/><input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_min" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_min" value="'.$value0.'" /><br/>';
		$fieldHtml .=JText::_('RANGESEARCH TO').'<br/><input class="inputbox" type="text" name="'.$calleObject->get('pluginType').$calleObject->get('key').'_max" id="'.$calleObject->get('pluginType').$calleObject->get('key').'_max" value="'.$value1.'" />';			
		
		//print_r($fieldHtml);
		$this->assign('fieldHtml',$fieldHtml);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		
		return $contents;
	}
	
}
