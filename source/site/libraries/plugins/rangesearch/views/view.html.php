<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';

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
			
		$layout='';
		
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
		$formName= '';
 		if(JString::strtolower($params->get('rangesearchType', 'date')) === 'date-range'){
			$layout='daterange';
			$mySess 	= & JFactory::getSession();
  			$formName	= $mySess->get('xiusModuleForm','','XIUS');
         		if($formName != '')
         			$formName = "_{$formName}";
      	}
		else{
			$layout = 'search';
		}
		
		$this->assign('pluginType',$pluginType);
		$this->assign('key',$key);		
		$this->assign('value0',$value0);
		$this->assign('value1',$value1);		
		$this->assign('formName',$formName);
		
		ob_start();
		$this->display($layout);
		$contents = ob_get_clean();
		
		return $contents;
	}
	
}
