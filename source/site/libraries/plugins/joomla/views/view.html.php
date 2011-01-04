<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'joomla'.DS.'joomlahelper.php';

class JoomlaView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		$layout  	= 	null;
		$paramsType	=	$calleObject->get('pluginType');
 		$key		=	$calleObject->get('key');
 		$infoType	=	Joomla::getCacheSqlSpec($key);
 		$formName 	= 	'';
 		
 		if($infoType == 'datetime NOT NULL' ){
  			// if module is displayin info
  			$mySess 	= JFactory::getSession();
  			$formName	= $mySess->get('xiusModuleForm','','XIUS');
         		if($formName != '')
         			$formName = "_{$formName}";

         	$layout = 'date'; 			
  		}
  		else if($infoType == 'tinyint(4) NOT NULL'){			
 			$layout = 'tiny';
  		}		
		
  		if($layout === null)
  			return parent::searchHtml($calleObject,$value);
  			
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		
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
