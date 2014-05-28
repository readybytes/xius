<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Plugin
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

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

class plgXiusxipt_privacy extends JPlugin
{
		
	function plgXiusxipt_privacy( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	function _loadXipt()
	{
		if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
			return false;

		if(!$this->_pluginStatus())
			return false;
		
		return true;
	}
	
	/**  Check plugin enable then return true.
	 *   If plugin disable or not installed then return false
	 */
	function _pluginStatus(){
	
		if(!(XiusHelperUtils::isPluginInstalledAndEnabled('xipt_community','community')))
			return false;
			
		if(!(XiusHelperUtils::isPluginInstalledAndEnabled('xipt_system','system')))
			return false;	

		return true;	
	}
	
	function xiusOnBeforeSaveInfo(&$postData)
	{	
		if(!$this->_loadXipt())
			return false;
		
		// is postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name ,$postData['params'])){
			$temp 		= $postData['params'][$this->_name];
			$postData['params'][$this->_name] = serialize($temp);
		}
		return true;
	}
	
	/*
	 * @trigger will return the XiProfileTypes privacy Data to be shown on page
	 * @where XiProfileTypes data will be filled
	 */
	function onBeforeRenderInfoDisplay(&$params)
	{
		if(!$this->_loadXipt())
			return false;

		// XITODO : clean up the following code
		// as no need of all data, we need only params

		$name			= $this->_name;		
		$param[$name]	= $params['params']->get($name);
		
		if($param[$name] == false || $param[$name] == '')
			unset($param[$name]);

		return $this->_xiusGetProfileTypes($param);
	}
	
	/*
	 * @will generate the html for XiProfileTypes privacy to be shown
	 */
	function _xiusGetProfileTypes($param)
	{
		$name				= $this->_name;
		$profileTypes		= XiusHelperXiptwrapper::getProfileTypeIds();
							
		$html 	= $this->_getProfileTypeHtml($profileTypes, $name, $param, 'multiple="multiple" size="9"');
		return $html;
	}	
	
	function _getProfileTypeHtml($profileType, $name, $param, $attribs = null)
	{
		if((!XiusHelperUtils::isPluginInstalledAndEnabled('xipt_community','community')) ||
		   (!XiusHelperUtils::isPluginInstalledAndEnabled('xipt_system','system'))){
		   	JError::raiseWarning(1001,XiusText::_('JSPT_SETUP_SCREEN_IS_NOT_CLEAN'));
		   	return false;
		   }
		$j15_path = (XIUS_JOOMLA_15)?'':DS.'xipt_privacy';
		$xmlPath 	  		= JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.'xipt_privacy'.$j15_path.DS.'param.xml';
        $iniPath        	= dirname(__FILE__) . DS .$this->_name.DS.'param.ini';
        $profileTypeData    = JFile::read($iniPath);
        
        if(JFile::exists($xmlPath))
			$config = new XiusParameter($profileTypeData, $xmlPath);
        else
        	$config = new XiusParameter('','');
           
        $config->bind($param);
        return $config->render(); 
	}
	
	function xiusOnAfterLoadAllInfo(&$allInfo, &$loginuser=null)
	{
		//Don't run when user is  admin or cache upadate time.
		if(JFactory::getApplication()->isAdmin() ||
		   JFactory::getSession()->get('updateCache', false) )
			return true;
		
		if(!$this->_loadXipt())
			return false;
			
		if($loginuser==null)
			$loginuser= JFactory::getUser();
			
		$profileId 		 =	XiusHelperXiptwrapper::getUserInfo($loginuser->id);
		$this->_setDisplayData($allInfo, $profileId);		
		return true;
	}
	
	/*
	 * @trigger will return the privacy html to be shown on page
	 * @where list data will be filled
	 */
	function xiusOnBeforeDisplayListDetails($params)
	{
		if(!$this->_loadXipt())
			return false;
		
		// run only Back-End
		if(JFactory::getApplication()->isSite())
				return false;
					
		return $this->_xiusGetProfileTypes($params);
	}

	function xiusOnBeforeSaveList(&$postData, &$params)
	{	
		if(!$this->_loadXipt())
			return false;
			
		// run only Back-End
		if(JFactory::getApplication()->isSite())
				return false;
		
		// is postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name,$postData['params']))
			$params[$this->_name] = serialize($postData['params'][$this->_name]);
			
		return true;
	}
	
	function xiusOnAfterLoadList(&$lists)
	{
		//Don't run in admin
		if(JFactory::getApplication()->isAdmin())
				return true;
		
		if(!$this->_loadXipt())
			return false;

		$userId		= JFactory::getUser()->id;
		$profileId	= XiusHelperXiptwrapper::getUserInfo($userId);	
		$this->_setDisplayData($lists, $profileId, true);

		$lists = array_values($lists);
		return true;
	}
	
	function _setDisplayData(&$data, $profileId, $list=false)
	{
		if(XiusHelperUtils::isAdmin($userid=null))
			return true;

		if(empty($data)) {
			return true;
		}
                
		$count = count($data);
		for($i =0 ; $i < $count ; $i++ ){		
			if(!isset($data[$i])) {
				continue;
			}
			$param = new XiusParameter('','');
			$param->bind($data[$i]->params);
			$profileTypeInfo= unserialize($param->get($this->_name));
		
			if(!$profileTypeInfo)
				continue;
			
			if($list && $this->_isListViewable($data[$i]->owner))
				continue ;

			if(in_array($profileId, $profileTypeInfo) || in_array("0", $profileTypeInfo))
				continue;
					
			unset($data[$i]);		
		}
	}
	
	function _isListViewable($ownerId)
	{
		$userId		= JFactory::getUser()->id;
		if(XiusHelperUtils::isAdmin($userId) 
				|| $ownerId === $userId)
			return true;
	}		
}
}
