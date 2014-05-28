<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusFactory
{
	static $instances = array();
	/*
	 * get Plugin-Instance
	 */
  static public function getPluginInstance($pluginName, $pluginId=0)
	{

		if(empty($pluginName) && $pluginId == 0 )
		   return false;
		
		// If formal parameter $pluginId set then get plugin name
		if($pluginId)
		{
			// return Cache data
			if(isset($instances[$pluginId])){
				return $instances[$pluginId];		
			}
			
			$filter['id']= $pluginId;
			$info  		 = XiusLibInfo::getInfo($filter);
			
			// When not existing information then treturn FALSE
			if(empty($info)){
			   return false;
			}   
			$pluginName  = $info[0]->pluginType;
		}
		
		$pluginClass = JString::ucfirst($pluginName);
		$pluginName  = strtolower($pluginName);
		$pluginPath	 = XIUS_PLUGINS_PATH. DS . $pluginName . DS . $pluginName.'.php';
		
		XiusError::assert(JFile::exists($pluginPath),"INVALID $pluginName FILE");

		// Include plugin path
		require_once $pluginPath;
		// When required only Plugin Instance
		if(!$pluginId){
			return new $pluginClass();
		}

		// get plugin instance ->bind  then return
		$instances[$pluginId] = new $pluginClass();
		$instances[$pluginId]->bind($info[0]);
	 	return $instances[$pluginId];
	}

  static public function getModalButtonObject($name,$text,$link,$width=750,$height=480,$handler ='iframe')
	{
		JHTML::_('behavior.modal', "a.{$name}");
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', $text );
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', $name);
        $buttonMap->set('options', "{handler: '$handler', size: {x: ".$width.", y: ".$height."}}");
        $buttonMap->set('link', $link);
        return $buttonMap;
	}

	//Returns a XiUS MVCT object
  static public  function getInstance($class, $type='',$prefix='', $reset=false)
	{
		static $instance=array();
		$prefix = empty($prefix) ? 'Xius': $prefix ;

		//generate class name
		$className	= JString::ucfirst($prefix)
					. JString::ucfirst($type)
					. JString::ucfirst($class);

		// Clean the name
		$className	= preg_replace( '/[^A-Z0-9_]/i', '', $className );

		//if already there is an object
		if(isset($instance[$className]) && !$reset){
			return $instance[$className];
		}

		//class_exists function checks if class exist,
		// and also try auto-load class if it can
		if(class_exists($className, true)===false)
		{
			XiusError::assert(false,"Class $className not found",1);
			return false;
		}

		//create new object, class must be autoloaded
		$instance[$className]= new $className();

		return $instance[$className];
	}

	// Reset instance variable (only test-case purpose)
  static public function resetStaticData()
	{
		//XITODO : probably creating memory leak here
		self::$instances = array();
	}
}