<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Installation
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}

class com_xiusInstallerScript
{
	public static $xiusIntallOrUpgrade = 'install';
	
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/

	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/
	public function install(JAdapterInstance $adapter)
	{
		if(JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_community') == false){
			JError::raiseError('Installation error', 'Unable to install it, JomSocial should be already installed');
			return false;
		}		
		
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'base'.DS.'route.php');
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'base'.DS.'text.php');
		require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
		require_once  JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';

		$this->xius_install();
	}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/

    public function update(JAdapterInstance $adapter)
	{
		self::$xiusIntallOrUpgrade = 'upgrade';
		$this->uninstall($adapter);		
		$this->install($adapter);
	}

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	*/
	public function uninstall(JAdapterInstance $adapter)
	{
		if(JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_community') == false){
			JError::raiseError('Installation error', 'Unable to install it, JomSocial should be already installed');
			return false;
		}
		
		require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
		
		$this->xius_uninstall();
		
	}

	function xius_install()
	{
		/*if(installPlugin() == false){
			JError::raiseError('INSTERR', XiusText::_("NOT ABLE TO INSTALL PLUGINS"));
		return false;
		}*/
		// Set Warning for removing older XiUS Version
		$adminPath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius';
		$siteFolder= Array('helper','libraries','models','tabels','elements','assets');
		foreach($siteFolder as $folder){
			if(JFolder::exists($adminPath.DS.$folder)){
				JError::raiseWarning("","You are Upgrading Your XiUS Package (Older to XIUS 2.6).
											So Please,Properly Remove XiUS 2.5.xxx or lower-version.
											'Any One' or 'All'(helper,libraries,models,tabels,elements,assets) folder exists
											in Back-end");
					
				break;
			}
		}
	
		if($this->installExtensions($adminPath.DS.'install'.DS.'extensions') == false){
			JError::raiseError('INSTERR', XiusText::_("NOT_ABLE_TO_INSTALL_EXTENSIONS"));
			return false;
		}
	
	
		$this->changePluginState('xius_system',true);
		$this->changePluginState('xius',true);
		$this->changePluginState('js_privacy',true);

		$this->enableExtension();

		//$this->changePluginState('xipt_privacy',true);
		//check if migration is required
		if(xiusMigration::isMigrationRequired()){
			xiusMigration::doMigration();
		}
		return true;
	}

	function installExtensions($extPath=null)
	{
		//if no path defined, use default path
		if($extPath==null)
			$extPath = dirname(__FILE__).DS.'extensions';
	
		if(!JFolder::exists($extPath))
		{
			$msg = "Extension path $extPath doesn't exist";

			JFactory::getApplication()->enqueueMessage($msg);			
			return false;
		}
		$extensions	= JFolder::folders($extPath);
	
		//no apps there to install
		if(empty($extensions))
			return true;
	
		//get instance of installer
		$installer =  new JInstaller();
		$installer->setOverwrite(true);
	
		//install all apps
		foreach ($extensions as $ext)
		{
			$msg = "Supportive Plugin/Module $ext Installed Successfully";
	
			// Install the packages
			if($installer->install($extPath.DS.$ext)==false)
				$msg = "Supportive Plugin/Module $ext Installation Failed";
	
			//enque the message
			JFactory::getApplication()->enqueueMessage($msg);
		}
	
		return true;
	}

	function changePluginState($pluginname, $action=1)
	{
		$db		= JFactory::getDBO();
	
		$query	= 'UPDATE ' . $db->quoteName( '#__extensions' )
		. ' SET '.$db->quoteName('enabled').'='.$db->Quote($action)
		.' WHERE '. $db->quoteName('element').'='.$db->Quote($pluginname) . "  AND `type`='plugin' ";
		
	
		$db->setQuery($query);
	
		if(!$db->query())
			return false;
	
		return true;
	}

	function xius_uninstall()
	{
		// disable plugins
		$this->disable_plugin('xius_system');
		$this->disable_plugin('xius');
		
		if(self::$xiusIntallOrUpgrade != 'upgrade') {
			$this->changeModuleState('mod_xiuslisting',0);
			$this->changeModuleState('mod_xiussearchpanel',0);
			$this->changeModuleState('mod_xiusproximity',0);
		}
	}
	
	function disable_plugin($pluginname)
	{
		$db			= JFactory::getDBO();
	
		if (XIUS_JOOMLA_15){
			$query	= 'UPDATE ' . $db->quoteName( '#__plugins' )
			. ' SET '.$db->quoteName('published').'='.$db->Quote('0')
			.' WHERE '. $db->quoteName('element').'='.$db->Quote($pluginname);
		}
	
		else{
			$query	= 'UPDATE ' . $db->quoteName( '#__extensions' )
			. ' SET '.$db->quoteName('enabled').'='.$db->Quote('0')
			.' WHERE '. $db->quoteName('element').'='.$db->Quote($pluginname) . "  AND `type`='plugin' ";
		}
	
	
		$db->setQuery($query);
		if(!$db->query())
			return false;
		return true;
	}
	
	function changeModuleState($moduleName,$state)
	{
		$db			= JFactory::getDBO();
		if (XIUS_JOOMLA_15){
			$query	= 'UPDATE ' . $db->quoteName( '#__modules' )
			. ' SET '.$db->quoteName('published').'='.$db->Quote($state)
			.' WHERE '.$db->quoteName('module').'='.$db->Quote($moduleName);
		}
		else{
			$query	= 'UPDATE ' . $db->quoteName( '#__extensions' )
			. ' SET '.$db->quoteName('enabled').'='.$db->Quote($state)
			.' WHERE '. $db->quoteName('element').'='.$db->Quote($moduleName) . "  AND `type`='module' ";
		}
	
		$db->setQuery($query);
	
		if(!$db->query())
			return false;
	
		return true;
	}
	
	//This function is called after intallation complete 
	function postflight($type, $parent)
	{
		$suffix = "action=".self::$xiusIntallOrUpgrade."&label=".JVERSION;
		
		ob_start();
		?>
		
		<script type="text/javascript">
			window.onload = function(){
				setTimeout("location.href = 'index.php?option=com_xius';", 5000);
			}
		</script>
		<iframe scrolling="no" frameborder="0" width="503px" src="http://www.readybytes.net/broadcast/xius-installed.html?<?php echo urlencode($suffix); ?>"></iframe>
		<?php 
		$script = ob_get_contents();
		ob_clean();
 		echo $script;

	}

	public function preflight($type, $parent)
	{
		if($type == 'install' || $type == 'update'){
			self::_deleteAdminMenu();
		}	
	}

	/**
	 * Joomla! 1.6+ bugfix for "Can not build admin menus"
	 */
	public static function _deleteAdminMenu()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		//get all records
		$query->delete('#__menu')
			  ->where($db->quoteName('type').' = '.$db->quote('component'))
			  ->where($db->quoteName('menutype').' = '.$db->quote('main'))
			  ->where($db->quoteName('link').' LIKE '.$db->quote('%index.php?option=com_xius%'));
	
		return $db->setQuery($query)->query();
	}
	
	public static function enableExtension()
	{
		$db		= JFactory::getDBO();
		$query	= 'UPDATE ' . $db->quoteName( '#__extensions' )
				. ' SET '.$db->quoteName('enabled').'='.$db->Quote('1')
				.' WHERE '. $db->quoteName('element').'='.$db->Quote('com_xius') . "  AND `type`='component' ";
		
		$db->setQuery($query);
	
		if(!$db->query())
			return false;
	
		return true;
	}
	
}

class xiusMigration
{
	public static function isMigrationRequired(){
		//if xius_config table is not present it means xius has never been installed
		//and migration is not required
		if(self::_isTableExist('xius_config')){
			$db = JFactory::getDBO();
			$query = 'SELECT * FROM `#__xius_config`';
			$db->setQuery($query);
			$results = $db->loadObjectList();
			//if version row is not present then migration is required.
			foreach ($results as $result){
				if($result->name == 'version')
					return false;
			}
			return true;
		}
		return false;
	}

	//check whether the given table exists or not
	public static function _isTableExist($tableName)
	{
		$database   = JFactory::getDBO();
		$query 	= "SHOW TABLES LIKE '%".$tableName."%'";
		$database->setQuery($query);
		$result 	= $database->loadResultArray();
		if(!empty($result)) return true;
		return false;
	}

	public static function doMigration()
	{
		self::migrationInConfig();
		self::migrationInInfoParams();
		self::migrationInListParams();

	}

	public static function migrationInConfig()
	{
		//add a version in xius_config table
		$db 	  = JFactory::getDBO();
		$sqlquery = "INSERT INTO `#__xius_config`(`name`,`params`)
			              	            VALUES ('version','".XIUS_VERSION."')";
		$db->setQuery($sqlquery);
		$db->query();
		//change 'xiusListCreator' param from usergroup's name to usergroup's id
		$cModel			 = XiusFactory::getInstance ('configuration' , 'model');
		$params          = $cModel->getParams();
		$params          = $params->toArray();
		$xiusListCreator = unserialize($params['xiusListCreator']);
		require_once XIUS_PATH_SITE_HELPER.DS.'users.php';
		foreach ($xiusListCreator as $key=>$value){
			if($value == 'All')
				continue;
			else
				$xiusListCreator[$key] = self::convertInGroupId($value);

			$params['xiusListCreator']	= $xiusListCreator;
			XiusModelConfiguration::save('config',$params);
		}
		return true;
	}

	public static function migrationInInfoParams()
	{
		$iModel	= XiusFactory::getInstance ( 'info','model' );
		$allInfo   = $iModel->getAllInfo();
		$instance  = new XiusFactory();
		foreach ($allInfo as $info){
			$param  	= $instance->getPluginInstance('',$info->id)->get('params');
			$paramArray = $param->toArray();
			$isacc  	= unserialize($paramArray['isAccessible']);
			foreach($isacc as $key=>$value){
				if($value == 'All')
					continue;
				else
					$isacc[$key] = self::convertInGroupId($value);
			}
			$paramArray['isAccessible'] = serialize($isacc);
			$param->bind($paramArray);
			$info->params = $param->tostring('INI');
			 
			//if plugintype is forcesearch then add a pluginparam 'operatorType' and
			// update 'value' from usergroup's name to usergroup's id
			//in case of usertype and profiletype
			if($info->pluginType == 'Forcesearch'){
				$_params      = $instance->getPluginInstance('',$info->id)->get('pluginParams');
				$pluginParams = $_params->toArray();
				$parentInfo   = XiusModelInfo::getInfo($info->key);
				//for profiletype info
				if($parentInfo->pluginType == 'Jsfields'){
					$filter 	  = array();
					$filter['id'] = $parentInfo->key;
					$fieldInfo    = Jsfieldshelper::getJomsocialFields($filter);
				}
				if($parentInfo->key == 'usertype' || (isset($fieldInfo) && $fieldInfo[0]->type == 'profiletypes')){
					$temp    = array();
					$temp[]  = self::convertInGroupId(
							unserialize($pluginParams['value']));
					$pluginParams['value']     = serialize($temp);
				}
				$pluginParams['operatorType'] = 'LIKE';
				$_params->bind($pluginParams);
				$info->pluginParams = $_params->toString('INI');
			}
			$iModel->save((array)$info);
		}
		return true;
	}

	//function to change groupname to groupid
	public static function convertInGroupId($value)
	{
		$groups    = XiusHelperUsers::getJoomlaGroups();
		foreach ($groups as $group){
			if($value == $group->{XIUS_JOOMLA_GROUP_VALUE})
				return $value = $group->id;
		}
		return $value;
	}

	public static function migrationInListParams()
	{
		$parameter  = new XiusParameter();
		$lModel    	= XiusFactory::getInstance ('list', 'model');
		$lists 	    = $lModel->getLists();
		//change param 'xiusListViewGroup' from groupname to groupid
		foreach ($lists as $list){
			$parameter->loadINI($list->params);
			$ListParams = $parameter->toArray();
			$listView 	= unserialize($ListParams['xiusListViewGroup']);
			foreach ($listView as $key=>$value)
				$listView[$key] = self::convertInGroupId($value);
				
			$ListParams['xiusListViewGroup'] = serialize($listView);
			$parameter->loadArray($ListParams);
			$list->params = $parameter->toString('INI');
			$lModel->save((array)$list);
		}
		return true;
	}
}
