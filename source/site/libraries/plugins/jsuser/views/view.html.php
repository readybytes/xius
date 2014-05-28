<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'joomla'.DS.'joomlahelper.php';

class JsuserView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$layout  	= 	null;
		$paramsType	=	$calleObject->get('pluginType');
 		$key		=	$calleObject->get('key'); 		
 		$formName 	= 	'';
 		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
 		 if($key === 'avatar')
 		{
 			$this->assign('value',$value);
 			$layout='avatar';
 		}
 		
	    if($key === 'profile_id')
 		{
 			$profileType= CFactory::getModel('profile');
 			$profileTypes=$profileType->getProfileTypes();
 		    $this->assign('profileTypes',$profileTypes);
 		    $this->assign('value',$value);
	        $layout='profile';
 		}
		
		if($key === 'posted_on'){
			$mySess 	= & JFactory::getSession();
  			$formName	= $mySess->get('xiusModuleForm','','XIUS');
         		if($formName != '')
         			$formName = "_{$formName}";

         	$layout = 'date'; 			
		}		
		
		if($layout === null)
  			return parent::searchHtml($calleObject,$value);
  			
		$this->assign('paramsType',$paramsType);
		$this->assign('key',$key);
		$this->assign('formName',$formName);
		$this->assign('value',$value);
			
		ob_start();
		$this->display($layout);
		$contents = ob_get_clean();
		return $contents;	
	}
	
}
