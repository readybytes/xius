<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusFactory
{

	function &getModel( $name ,$location='admin', $reset=false )
	{
		static $modelInstances = null;

		//find class name
		$className = 'Xius';
		if($location === 'site'){
			$className = 'Xiussite';
		}

		$className = $className.'Model'.JString::ucfirst($name);

		//we might have conflicting model names in admin/site
		if(!$reset && isset($modelInstances[$className]))
			return $modelInstances[$className];

		//check for classname
		if(class_exists($className, true)===false)
		{
			JError::raiseError(500,XiusText::_("Class $className not found"));
			return false;
		}

		$modelInstances[$className] = new $className;
		return $modelInstances[$className];
	}

	static public function getPluginInstance($pluginName,$bindArray = '',$isBindRequired = false)
	{
		$pluginClassName = $pluginName;
		$pluginName = strtolower($pluginName);
		$pluginPath	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . $pluginName . DS . $pluginName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($pluginPath))
		{
			JError::raiseError(400,XiusText::_("INVALID PLUGIN FILE"));
			return false;
		}

		require_once $pluginPath;

		//$instance will comtain all plugin object according to info
		//Every info will have different object
		static $instances = array();
		if(isset($instances[$pluginName])){
			/*Clean object first */
			$instances[$pluginName]->cleanObject();
		}
		else
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


 	function getLibraryPluginHandler()
    {
        static $instance =null;

        if($instance==null)
            $instance = new XiusLibrariesPluginhandler();

        return $instance;
    }


	public function getErrorObject()
	{
		static $object;
		if(isset($object))
			return $object;

		$object = new XiusError();
		return $object;
	}

	public function getCacheObject()
	{
		static $object;
		if(isset($object))
			return $object;

		$object = new XiusCache();
		return $object;
	}
	//XITODO : send parameters as array of args
	function getModalButtonObject($name,$text,$link,$width=750,$height=480)
	{
		JHTML::_('behavior.modal', "a.{$name}");
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', XiusText::_( $text ));
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', $name);
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".$width.", y: ".$height."}}");
        $buttonMap->set('link', $link);
        return $buttonMap;
	}

	//Returns a MVCT object
	static function getInstance($name, $type, $prefix='Xiussite', $refresh=false)
	{
		static $instance=array();

		//generate class name
		$className	= JString::ucfirst($prefix)
					. JString::ucfirst($type)
					. JString::ucfirst($name);

		// Clean the name
		$className	= preg_replace( '/[^A-Z0-9_]/i', '', $className );

		//if already there is an object
		if(isset($instance[$className]))
			return $instance[$className];

		//class_exists function checks if class exist,
		// and also try auto-load class if it can
		if(class_exists($className, true)===false)
		{
			JError::raiseError(500,XiusText::_("Class $className not found"));
			return false;
		}

		//create new object, class must be autoloaded
		$instance[$className]= new $className();

		return $instance[$className];
	}
	
	function getTableInstance( $type, $prefix = 'XiusTable')
	{
		$type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);
		$tableClass = $prefix.ucfirst($type);
		if (!class_exists($tableClass,true))
		{
			JError::raiseWarning( 0, 'Table class ' . $tableClass . ' not found in file.' );
			return false;
		}
		$db = JFactory::getDBO();
		$instance = new $tableClass($db);
		return $instance;
	}

/*
	static public function getAllPluginInstanceFromProperty($pluginName,$bindArray = '',$isBindRequired = false)
	{
		$pluginClassName = $pluginName;
		$pluginName = strtolower($pluginName);
		$pluginPath	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . $pluginName . DS . $pluginName.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($pluginPath))
		{
			JError::raiseError(400,XiusText::_("INVALID PLUGIN FILE"));
			return false;
		}

		require_once $pluginPath;

		//$instance will comtain all plugin object according to info
		//Every info will have different object
		static $instances = array();
		if(isset($instances[$pluginName])){
			//Clean object first
			$instances[$pluginName]->cleanObject();
		}
		else
			$instances[$pluginName] = new $pluginClassName();


		// load id when it's not 0
		 // load 0 is handeled by load fn so it's time for relaxation
		//XITODO : skip load , let handles it by calle self
		 // they should call bind function without work
		// they can have info object themselves
		 //
		if($isBindRequired && $bindArray)
				$instances[$pluginName] = $instances[$pluginName]->bind($bindArray);


		return $instances[$pluginName];
	}
*/

}
