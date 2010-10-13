<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelpersUtils
{
	function isComponentExist($comName,$bothReq=false)
	{
		$frontcompath = JPATH_ROOT.DS.'components'.DS.$comName;
		$admincompath = JPATH_ADMINISTRATOR.DS.'components'.DS.$comName;
		
		if($bothReq) {
			if(JFolder::exists($frontcompath) && JFolder::exists($admincompath))
				return true;
			
			return false;
		}
		
		if(JFolder::exists($frontcompath) || JFolder::exists($admincompath))
			return true;
			
		return false;
	}
	
	
	function getValueFromXiusParams($paramName,$what,$default='')
	{
			return $paramName->get($what,$default);
	}
	
	
	function isTableExist($tableName)
	{
		global $mainframe;
	
		$tables	= array();
		
		$database = &JFactory::getDBO();
		$tables	= $database->getTableList();
	
		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
	}


	public function getAvailablePlugins()
	{
		$path	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins';
	
		jimport( 'joomla.filesystem.folder' );
		$plugins = array();
		$plugins = JFolder::folders($path);
		
		$pluginInfo= Array();
		foreach ($plugins as $plugin)
		{
			$xmlPath= $path.DS.$plugin.DS.$plugin.'.xml';
			if(JFile::exists($xmlPath)===false)
				continue;

			$xml = JFactory::getXMLParser('Simple');
			if(!$xml->loadFile($xmlPath))
				continue;

			$params =  $xml->document;
			$pluginInfo[$plugin]['name']	= trim($params->getElementByPath( 'params/name' )->data());
			$pluginInfo[$plugin]['title']	= $params->getElementByPath( 'params/title' )->data();
			$pluginInfo[$plugin]['desc']	= $params->getElementByPath( 'params/description' )->data();
		}
		return $pluginInfo;
	}
	
	
	public function getDebugMode()
	{
		$debugMode = self::getConfigurationParams('"xiusDebugMode"',false);
		return $debugMode;
	}
	
	
	public function getDisplayInformationCount()
	{
		/* -1 means display all information ,from configuration*/
		return XIUS_ALL;
	}
	
	
 	function isAdmin($userid)
	{
		$user	=& JFactory::getUser($userid);		
		return ( $user->usertype == 'Super Administrator' || $user->usertype == 'Administrator' );  	
	}
	
	
	function getUserLimit()
	{
		$userLimit = self::getConfigurationParams('xiusUserLimit',2000);
		return $userLimit;
		//return XIUS_USER_LIMIT;
	}
	
	
	function getOtherConfigParams($configname , $what , $default = 0)
	{
		$cModel = XiusFactory::getModel('configuration');
		$params	= $cModel->getOtherParams($configname);
		
		$result = $params->get($what,$default);
		return $result;
	}
	
	
	function getKeyForCacheUpdate()
	{
		$key = self::getConfigurationParams('xiusKey',0);
		return $key;
	}
	
	
	function getConfigurationParams($what,$default=0)
	{
		$cModel = XiusFactory::getModel('configuration');
		$params	= $cModel->getParams();
		$result = $params->get($what,$default);
		return $result;
	}
	
	
	function verifyCronRunRequired($secureKey = null,$currentTime = null)
	{
		if($secureKey == null)
			$secureKey=JRequest::getVar('xiuskey', 0, 'GET','string');
		
		$setKey = XiusHelpersUtils::getKeyForCacheUpdate();
		
		if($secureKey != $setKey)
			return false;
			
		$startTime = XiusHelpersUtils::getOtherConfigParams('cache',XIUS_CACHE_START_TIME,0);
		
		$endTime = XiusHelpersUtils::getOtherConfigParams('cache',XIUS_CACHE_END_TIME,0);
		
		if($currentTime == null)
			$currentTime = XiusLibrariesUsersearch::getTimestamp();
		
		$timeGap = $currentTime - $endTime;
		$totalRunTime = $endTime - $startTime;
		
		$diffReq = XIUS_CRON_TIME_MULTIPLIER * $totalRunTime;
		
		/*XITODO: Minimun time for updating cache
		 * should be 60 sec or 1 min
		 */
		if($timeGap < 60 || $timeGap < $diffReq)
			return false;
			
		return true;
	}
	
	function isPluginInstalledAndEnabled($pluginname,$type,$checkenable = false)
	{
		$db			=& JFactory::getDBO();
		
		$extraChecks = '';
		if($checkenable)
			$extraChecks = ' AND '.$db->nameQuote('published').'='.$db->Quote(true);
			
		$query	= 'SELECT * FROM ' . $db->nameQuote( '#__plugins' )
	          .' WHERE '.$db->nameQuote('folder').'='.$db->Quote($type)
	          .' AND '.$db->nameQuote('element').'='.$db->Quote($pluginname)
	          . $extraChecks;

		$db->setQuery($query);		
		
		$plugin	= $db->loadObjectList();
		
		if(!$plugin)
			return false;
			
		return true;
	}
	
/*
	function getJoomlaUserGroupData($gid,$what='value')
	{
		if(!$gid)
			return false;
			
		$db= & JFactory::getDBO();
		$sql = ' SELECT '.$what.' FROM '.$db->nameQuote('#__core_acl_aro_groups') 
				.' WHERE '.$db->nameQuote('id').' = '.$db->Quote($gid);
		$db->setQuery($sql);
		return $db->loadResult();
	}
*/
	
}
