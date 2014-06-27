<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperUtils
{
	/*
	 * Check Component Exists or not
	 * $comName have componentname.
	 * $bothReq have true then check Component exists at both-end (front & back)
	 */
	public static function isComponentExist($comName,$bothReq=false)
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
	/*
	 * return XiUS Param Value
	 */
	
	public static function getValueFromXiusParams($paramName,$what,$default='')
	{
			return $paramName->get($what,$default);
	}
	
	
	public static function isTableExist($tableName)
	{
		$mainframe = JFactory::getApplication();
	
		$tables	= array();
		
		$database = JFactory::getDBO();
		$tables	  = $database->getTableList();
	
		return in_array( $mainframe->getCfg( 'dbprefix' ) . $tableName, $tables );
	}


	public static function getAvailablePlugins()
	{
		//$path	= JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins';
	
		jimport( 'joomla.filesystem.folder' );
		$plugins = array();
		$plugins = JFolder::folders(XIUS_PLUGINS_PATH);
		
		$pluginInfo= Array();
		foreach ($plugins as $plugin)
		{
			$xmlPath= XIUS_PLUGINS_PATH.DS.$plugin.DS.$plugin.'.xml';
			if(JFile::exists($xmlPath)===false)
				continue;

			$xml = new XiusSimpleXML();
			if(!$xml->loadFile($xmlPath))
				continue;

			$params =  $xml->document;
			$pluginInfo[$plugin]['name']	= trim($params->getElementByPath( 'params/name' )->data());
			$pluginInfo[$plugin]['title']	= $params->getElementByPath( 'params/title' )->data();
			$pluginInfo[$plugin]['desc']	= $params->getElementByPath( 'params/description' )->data();
		}
		return $pluginInfo;
	}
	
 	public static function isAdmin($userid=null)
	{
		if(!$userid){
			return false;
		}

		return JFactory::getUser($userid)->authorise('core.login.admin');
	}
	
	
	// XiTODO:: Remove it, When implementing automatic cache updation.
	public static function getOtherConfigParams($configname , $what , $default = 0)
	{
		$cModel = XiusFactory::getInstance ('configuration', 'model');
		$params	= $cModel->getOtherParams($configname);
		
		$result = $params->get($what,$default);
		return $result;
	}
	
	public static function getConfigurationParams($what,$default=0)
	{
		$cModel = XiusFactory::getInstance ('configuration', 'model');
		$params	= $cModel->getParams();
		$result = $params->get($what,$default);
		return $result;
	}
	
	
	public static function verifyCronRunRequired($secureKey = null,$currentTime = null)
	{
		if($secureKey == null)
			$secureKey=JRequest::getVar('xiuskey', 0, 'GET','string');
		
		//get xiuskey for cache update
		$setKey = XiusHelperUtils::getConfigurationParams('xiusKey',0);
		
		if($secureKey != $setKey)
			return false;
			
		$startTime = XiusHelperUtils::getOtherConfigParams('cache',XIUS_CACHE_START_TIME,0);
		
		$endTime = XiusHelperUtils::getOtherConfigParams('cache',XIUS_CACHE_END_TIME,0);
		
		if($currentTime == null)
			$currentTime = XiusLibCron::getTimestamp();
		
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

	/*
	 * Check Plugin status.
	 * Here only use XiPT Plugins Enable or not  
	 */
	public static function isPluginInstalledAndEnabled($pluginname,$type,$checkenable = false)
	{	
		if(!JPluginHelper::isEnabled($type,$pluginname))
			return false;
			
		return true;
	}
	
	/**
     * load Xius jQuery, but we should load it only when it is set in backend.
	 * @since Xius4.1
     */
   	public static function loadJQuery()
    {
        static $loaded=false;

        $loadJquery	= self::getConfigurationParams('xiusLoadJquery',1);
        if($loaded || !$loadJquery)
            return true;

        JFactory::getDocument()->addScript(JUri::root() .'components/com_xius/assets/js/jquery1.4.2.js');
        JFactory::getDocument()->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );

        $loaded = true;
        return true;
    }

    /**
     * load joms.jquery.js if not loaded
	 * @since Xius4.1
     */
    public static function loadJomsJquery()
    {
        if(!defined('C_ASSET_JQUERY')){

            $jsVersion = self::getJSVersion();
            if(version_compare($jsVersion,'3.1') >= 0) {
                require_once COMMUNITY_COM_PATH . DIRECTORY_SEPARATOR. 'views'.DIRECTORY_SEPARATOR.'views.php';
                $view = new CommunityView();
                $view->attachHeaders();
            } else {
                JFactory::getDocument()->addScript( JUri::base() .'components/com_community/assets/joms.jquery.js' );
            }
        }
        return true;
    }
	
   public static function getUrlpathFromFilePath($filepath)
    {
    	return preg_replace('#[/\\\\]+#', '/', $filepath);
    }
       
	public static function getJSVersion()
	{	
		$CMP_PATH_ADMIN	= JPATH_ROOT . DS. 'administrator' .DS.'components' . DS . 'com_community';
	
		$parser		= new XiusSimpleXML();
		$xml		= $CMP_PATH_ADMIN . DS . 'community.xml';
	
		$parser->loadFile( $xml );
	
		$doc		= $parser->document;
		$element	= $doc->getElementByPath( 'version' );
		$version	= $element->data();
	
		return $version;
	} 

/*
	 * this function will return the Strin, Its Similer To preg_quote
	 */
	public static function XIUS_str_ireplace($search, $replace, $str, $count = NULL)
	{
		jimport('phputf8.str_ireplace');
		if ( $count === FALSE ) {
			return self::XIUS_utf8_ireplace($search, $replace, $str);
		} else {
			return self::XIUS_utf8_ireplace($search, $replace, $str, $count);
		}
	}
	
	/*
	 *This Function Is Replacement Of utf8_ireplace Because preg_quote not working with joomla 1.6 
	 */
	public static function XIUS_utf8_ireplace($search, $replace, $str, $count = NULL){

	    if ( !is_array($search) ) {
	
	        $slen = strlen($search);
	        if ( $slen == 0 ) {
	            return $str;
	        }
	
	        $lendif = strlen($replace) - strlen($search);
	        $search = utf8_strtolower($search);
	
	        $search = preg_quote($search, '/');
	        $lstr = utf8_strtolower($str);
	        $i = 0;
	        $matched = 0;
	        while ( preg_match('/(.*)'.$search.'/Us',$lstr, $matches) ) {
	            if ( $i === $count ) {
	                break;
	            }
	            $mlen = strlen($matches[0]);
	            $lstr = substr($lstr, $mlen);
	            $str = substr_replace($str, $replace, $matched+strlen($matches[1]), $slen);
	            $matched += $mlen + $lendif;
	            $i++;
	        }
	        return $str;
	
	    } else {
	
	        foreach ( array_keys($search) as $k ) {
	
	            if ( is_array($replace) ) {
	
	                if ( array_key_exists($k,$replace) ) {
	
	                    $str = utf8_ireplace($search[$k], $replace[$k], $str, $count);
	
	                } else {
	
	                    $str = utf8_ireplace($search[$k], '', $str, $count);
	
	                }
	
	            } else {
	
	                $str = utf8_ireplace($search[$k], $replace, $str, $count);
	
	            }
	        }
	        return $str;
	
	    }

	}  
     
}
