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

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgXiusjs_privacy extends JPlugin
{
		
	function plgXiusjs_privacy( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	function _loadXius()
	{				
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;
		
		require_once $includePath;
		return true;
	}
	
	/*
	 * @trigger will return the privacy html to be shown on page
	 * @where list data will be filled
	 */
	function xiusOnBeforeDisplayListDetails($params)
	{
		if(!$this->_loadXius())
			return false;
				
		return $this->_xiusGetListPrivacyHtml($params);
	}
	
	/*
	 * @will generate the html for list privacy to be shown
	 */
	function _xiusGetListPrivacyHtml($params)
	{
	$j15_path = (XIUS_JOOMLA_15)?'':DS.$this->_name;
	$xmlPath 	= $includePath = JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.$this->_name.$j15_path.DS.'param.xml';
        $iniPath    = dirname(__FILE__) . DS .$this->_name.DS.'param.ini';
        $listData   = JFile::read($iniPath);
        
        if(JFile::exists($xmlPath))
			$config = new XiusParameter($listData, $xmlPath);
        else
        	$config = new XiusParameter('','');
           
        $config->bind($params);
        return $config->render();

	}
	
	function xiusOnBeforeSaveList($postData, $params)
	{	
		if(!$this->_loadXius())
			return false;
		
		// is postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name,$postData['params'])){
			$params[$this->_name] = $postData['params'][$this->_name];
			return true;
		}

		return true;
	} 
	
	function xiusOnAfterLoadList($lists)
	{
		$app = JFactory::getApplication();

		//Don't run in admin
		if($app->isAdmin())
				return true;
		
		if(!$this->_loadXius())
			return false;

		$loggedinUser = JFactory::getUser();				
		$count = count($lists);
		for($i =0 ; $i < $count ; $i++ ){
			$params = new XiusParameter('','');
			$params->bind($lists[$i]->params);
			$privacy = $params->get($this->_name,'public');
			$isViewable = $this->_isListViewable($privacy,$loggedinUser,$lists[$i]->owner);
			if($isViewable === true)
				continue;
			
			unset($lists[$i]);
		}
		$lists = array_values($lists);
		return true;
	}
	
	
	function onBeforeRenderInfoDisplay($data)
	{
		if(!$this->_loadXius())
				return false;
				
		$param		  = array();	
		$name		  = $this->_name;
		$param[$name] = $data['params']->get($name);
		
		if($param[$name] == '')
		  unset($param[$name]);

		return $this->_xiusGetListPrivacyHtml($param);
	}

	function xiusOnBeforeSaveInfo($postData)
	{	
		if(!$this->_loadXius())
			return false;
		
		// is postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name ,$postData)){
			$postData['params'][$this->_name] = $postData[$this->_name];
		}
		return true;
	}

/*	
	function xiusOnAfterLoadAllInfo($allInfo, $loginuser=null)
	 {
		$app = JFactory::getApplication();
		
		//Don't run in admin
		if($app->isAdmin())
			return true;
		
		if(!$this->_loadXius())
			return false;
			
		if($loginuser==null)
			$loginuser= JFactory::getUser();
			
		//$userId	 		 =	$loginuser->id;
		$count = count($allInfo);
		for($i =0 ; $i < $count ; $i++ ){
			$params = new JParameter('','');
			$params->bind($allInfo[$i]->params);
			$privacy = $params->get($this->_name,'public');
			$isViewable = $this->_isListViewable($privacy,$loginuser);
			if($isViewable === true)
				continue;
			
			unset($allInfo[$i]);
		}
		return true;		
	}
*/
	
	function _isListViewable($privacy,$loggedinUser,$ownerId)
	{
		if(XiusHelperUtils::isAdmin($loggedinUser->id) 
				|| $ownerId === $loggedinUser->id)
			return true;
			
		switch($privacy){
			case 'public' : 
							return true;
							break;
							
			case 'member' : 
							if(!$loggedinUser->usertype || $loggedinUser->usertype === 'Guest Only')
								return false;
								
							return true;
							break;
							
			case 'friend' : 
							if($this->_isFriend($loggedinUser->id,$ownerId))
								return true;
								
							return false;
							break;
							
			case 'self'	  : 
							if($loggedinUser->id === $ownerId)
								return true;
								
							return false;
							break;
							
			default       :
							return true;				
		}
	}
	
	function _isFriend($userId, $otherUserId)
    {
		//XITODO : Cache the results
    	$db      = & JFactory::getDBO();
        $query   = 'SELECT '. $db->quoteName('connection_id').'  FROM ' . $db->quoteName( '#__community_connection')
        			.' WHERE '. $db->quoteName('connect_from').'='.$db->Quote($userId)
                    .' AND '. $db->quoteName('connect_to').'='.$db->Quote($otherUserId)
                    .' AND '. $db->quoteName('status').'='.$db->Quote('1');
                                       
        $db->setQuery( $query );
        return $db->loadResult();                
    }	
}
}
