<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

// If Xius System Plugin disabled then do nothing
$state = JPluginHelper::isEnabled('system', 'xius_system');
if(!$state){
    return true;
} else {

class plgXiusjsmultiprofile_privacy extends JPlugin
{
	function plgXiusjsmultiprofile_privacy( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	//Check if jomsocial multiprofile is enabled or not
	function _isJSMultiPTypeEnabled()
	{
		$config		= CFactory::getConfig();
		return $config->get('profile_multiprofile');	
	}
	
	function xiusOnBeforeSaveInfo(&$postData)
	{
	 // if postdata of this plugin is set then, set it on the plugin name
		if(array_key_exists($this->_name ,$postData['params']))
			$postData['params'][$this->_name] = serialize($postData['params'][$this->_name]);
		return true;
	}
	
	function onBeforeRenderInfoDisplay($params)
	{
        //send only the param that is related to this plugin 	
		$param[$this->_name] = $params['params']->get($this->_name);
		
		if($param[$this->_name] == false || $param[$this->_name] == '')
			unset($param[$this->_name]);
		return $this->_getMultiprofileHtml($param);
	}
	
	//get the html for plugin params
	function _getMultiprofileHtml($param)
	{
        //if js multiprofile is disable then show a warning
		if(!$this->_isJSMultiPTypeEnabled()){
		  JError::raiseWarning(1001,XiusText::_('MULTIPROFILETYPE_DISABLED'));
		return false;
		}
		$j15_path 			= (XIUS_JOOMLA_15)?'':DS.'jsmultiprofile_privacy';
		$xmlPath 	  		= JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.'jsmultiprofile_privacy'.$j15_path.DS.'param.xml';
        $iniPath        	= dirname(__FILE__) . DS .$this->_name.DS.'param.ini';
        $MprofileTypeData   = JFile::read($iniPath);
        $config				= new XiusParameter('','');
        if(JFile::exists($xmlPath))
			$config = new XiusParameter($MprofileTypeData, $xmlPath);
        
   		$config->bind($param);
        return $config->render();
	}
	
	function xiusOnAfterLoadAllInfo($allInfo, $loginuser=null)
	{
		//Don't run when user is  admin or cache upadate time.
		if( JFactory::getApplication()->isAdmin() ||
		   	JFactory::getSession()->get('updateCache', false) )
			return true;
		
		if($loginuser == null)
			$loginuser  = CFactory::getUser();
		
		$multiprofileid = $loginuser->_profile_id;
		$this->_setDisplayData($allInfo, $multiprofileid);		
		return true;
	}
	
	function _setDisplayData(&$allInfo, $multiprofileid , $list = false)
	{    
        //if logged-in user is admin then don't restrict him    
        if(XiusHelperUtils::isAdmin($userid=null))
           return true;  
        $count = count($allInfo);
		for($i =0 ; $i < $count ; $i++ ){		
			$param = new XiusParameter('','');
			$param->bind($allInfo[$i]->params);
			$MprofileTypeInfo = unserialize($param->get($this->_name));
			
			if(!$MprofileTypeInfo || in_array($multiprofileid, $MprofileTypeInfo) 
			                      || in_array("0",$MprofileTypeInfo))
				continue;
				
			if($list && $this->_isListViewable($allInfo[$i]->owner))
				continue ;

			unset($allInfo[$i]);
		}
	}
	
	function _isListViewable($ownerId)
	{
		$userId		= JFactory::getUser()->id;
		if(XiusHelperUtils::isAdmin($userId) 
				|| $ownerId === $userId)
			return true;
	}		
	
	/*
	 * @trigger will return the privacy html to be shown on page
	 * @where list data will be filled
	 */
	function xiusOnBeforeDisplayListDetails($params)
	{		
		// run only in Back-End
		if(JFactory::getApplication()->isSite())
				return false;
		return $this->_getMultiprofileHtml($params);
	}
	
	function xiusOnBeforeSaveList($postData, $params)
	{	
		// run only in Back-End
		if(JFactory::getApplication()->isSite())
				return false;
		// if postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name,$postData['params']))
			$params[$this->_name] = serialize($postData['params'][$this->_name]);
		return true;
	}
	
	function xiusOnAfterLoadList($lists)
	{
		//Don't run in admin
		if(JFactory::getApplication()->isAdmin())
				return true;
		$user		= CFactory::getUser();
		$multiProfileId = $user->_profile_id;	
		$this->_setDisplayData($lists, $multiProfileId, true);

		$lists = array_values($lists);
		return true;
	}
}

}
