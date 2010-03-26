<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusFactory
{	
	public function getPluginInstance($pluginName,$id=0,$bindArray = '',$isBindRequired = false)
	{
		$pluginClassName = $pluginName;
		$pluginName = strtolower($pluginName);
		$pluginPath	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . $pluginName . DS . $pluginName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($pluginPath))
		{
			JError::raiseError(400,JText::_("INVALID PLUGIN FILE"));
			return false;
		}

		require_once $pluginPath;
			
		//$instance will comtain all plugin object according to info
		//Every info will have different object
		static $instances = array();
		if(!isset($instances[$pluginName]))
				$instances[$pluginName] = new $pluginClassName();
		
		/* load id when it's not 0
		 * load 0 is handeled by load fn so it's time for relaxation*/
		/*XITODO : skip load , let handles it by calle self
		 * they should call bind function without work
		 * they can have info object themselves
		 */
		if($isBindRequired && $bindArray)
				$instances[$pluginName] = $instances[$pluginName]->bind($bindArray);
		
		
		return $instances[$pluginName];	
	}
	
	
	/*it will create object and load information
	 * like field -> Gender ( params , key )  will be loaded
	 */
	public function getPluginInstanceFromId($id,$checkPublished=false)
	{
		$filter = array();
		$filter['id']	= $id;
		if($checkPublished)
			$filter['published']	= 1;
		
		$info = XiusLibrariesInfo::getInfo($filter);
		if($info){
			$pluginObject = self::getPluginInstance($info[0]->pluginType);
			$pluginObject->bind($info[0]);
			return $pluginObject;
		}
		
		return false;
	}
	
	
	public function getErrorObject()
	{
		static $object;
		if(isset($object))
			return $object;
			
		$object = new XiusError();
		return $object;
	}
	
	
	public function getDebugMode()
	{
		/*XITODO : get parameter from configuration*
		 */
		return false;
	}
	
	
}
