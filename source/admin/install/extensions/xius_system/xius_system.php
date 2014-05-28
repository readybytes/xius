<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Plugin
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}

jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return false;
	
class plgSystemxius_system extends JPlugin
{
	function plgSystemxius_system( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	
	// $data is un-usable
	function onUsInfoUpdated($data)
	{   
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		// we can driectly call "update cache" function
		return $plgHandler->onUsInfoUpdated($data);
	}
	
	
	function onAfterSearchQuery($data, $sort, $dir)
	{
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		return $plgHandler->onAfterSearchQuery($data, $sort, $dir);
	}
	
	function onAfterRoute()
	{	
		$mainframe = JFactory::getApplication();

		//Don't run in admin
		if($mainframe->isAdmin())
			return;

	 	// take to xius search if community search is performed
	 	$input = JFactory::getApplication()->input;
		
		$option = $input->get('option','');
		$view   = $input->get('view','');
		$task   = $input->get('task','');
		$user   = JFactory::getUser();

		if($option != 'com_community')
			return false;	
		
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');

		//update xius_jsfields_values table on user registration
		if( $task === 'registerAvatar' && isset($user)){
			$this->onUsInfoUpdated($data = null);
			require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'fieldtable.php';
			XiusJsfieldTable::updateUserData(JFactory::getSession()->get('tmpUser')->get('id'));
		}
		
		if( $view != 'search' || $task != 'advancesearch')
			return;		

		$xiusReplaceSearch=XiusHelperUtils::getConfigurationParams('xiusReplaceSearch',0);
		if(!$xiusReplaceSearch)
			return false;
			
		/*
		 * If jom social is integrated with XIUS then redirect to js + XIUS URL
		 * else to XIUS
		 */
		$integrateJS =XiusHelperUtils::getConfigurationParams('integrateJomSocial',0);	
		$url = "index.php?option=com_xius";
		if($integrateJS)
			$url = "index.php?option=com_community&view=users&usexius=1"; 
		
		$mainframe->redirect(XiusRoute::_($url,false));			
	}

	function onAfterXiusCacheUpdate()
	{					
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		$pluginHandler->getGeocodesOfInvalidAddress();
		return;
	}
	
	function onBeforeXiusCacheUpdate()
	{					
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		return $pluginHandler->createGeocodeTable();		
	}
	
	function xiusOnBeforeAllListDisplay($lists,$loggedinUser)
	{
		return true;
	}
	
	function onBeforeMiniProfileDisplay($data)
	{	
		//if xiusJsfieldPrivacy param is set to YES then only proceed 
		if(!XiusHelperUtils::getConfigurationParams('xiusJsfieldPrivacy',0))
			return true;
			
		$coloum_alias = null;
		$infoKey	  = array();
		$jsInfo_exist = false;
		foreach ($data['allInfo'] as $infoid){
			if( $infoid->pluginType == 'Jsfields'){
				$jsInfo_exist = true;
			    $infoKey[$infoid->id] = $infoid->key;	
				$coloum_alias 		 .= ",SUM(if( `field_id`= $infoid->key,`access`,0)) AS jsfield_".$infoid->key;
			}
		}
		if($jsInfo_exist){
			//get jsfieldInfo Ids of infos that are in $data['appliedInfo'] 
			$jsfieldInfo = array();
			$otherInfos	 = array();
			$infoIds 	 = array_keys($infoKey);
			foreach ($data['appliedInfo'] as $key=>$value){
				if(in_array($value['infoid'],$infoIds))
					$jsfieldInfo[$value['infoid']] = $value;
				else{
					$otherInfos[$value['infoid']] = $value;
				}
			}
			//get userids to be checked for privacy
			$userids = null;
			$userids = implode(',',array_keys($data['userprofile']));
			if(empty($userids))
				return true;
				
			//get access coloum for all custom info
			$query = new XiusQuery();
			$query->select('`user_id`'.$coloum_alias)
				  ->from('`#__community_fields_values`')
				  ->where('`user_id` IN ('.$userids.')')
			      ->group('`user_id`');
			$results = $query->dbLoadQuery()->loadObjectList('user_id');
			$this->_applyJsfieldPrivacy($data,$results,$infoKey,$jsfieldInfo,$otherInfos);		
		}
		return true;
	}

	/**
	 * unset profileinfo and user according to their field accesses
	 */
	function _applyJsfieldPrivacy(&$data,$results,$infoKey,$jsfieldInfo,$otherInfos)
	{
		//let's check the viewer's relation to the result profiles to be shown
		$visitor = CFactory::getUser();
		$site_access = 0;
		$unsetUsers  = array();
		if($visitor->id > 0){
			$site_access = PRIVACY_MEMBERS;
		}
		foreach ($results as $result){
			$count = 0;
	    	$isfriend = $visitor->isFriendWith($result->user_id);
			$access_limit = $site_access;
	    	//let's set the maximum access limit viewer can go
	    	//every user is friend with himself 
			if( $isfriend){
				$access_limit = PRIVACY_FRIENDS;
				//if result user is the visitor then set access level to 'only me' 
				if($visitor->id == $result->user_id) 
					$access_limit = PRIVACY_PRIVATE;
			}
			foreach ($infoKey as $key=>$value){
				$jsfield = 'jsfield_'.$value;
				if((int)$result->$jsfield > $access_limit){
					if(isset($jsfieldInfo[$key]))
						$count++;
					unset($data['userprofile'][$result->user_id][$key]);	
				}
			}
			if(!empty($data['appliedInfo']) && !empty($jsfieldInfo) && $count == count($jsfieldInfo)){
				$unsetUsers[$result->user_id] = $result->user_id;
			}
		}
		$this->_unsetUsers($unsetUsers,$otherInfos,$data);
		return;
	}
	
	function _unsetUsers($unsetUsers,$otherInfos,&$data)
	{
		$config = XiusHelperUtils::getConfigurationParams('xiusDefaultMatch');
		foreach ($unsetUsers as $userid){
			$unset = true;
			$matchAnyOrAll = JFactory::getApplication()->input->get('xiusjoin',$config);
			//if match any condition then only check these
			if($matchAnyOrAll == 'OR'){
				foreach ($otherInfos as $key=>$value){
					if( $value['formatvalue'] == XiusText::_('ALL_AVAILABLE') || 
                        $value['formatvalue'] == XiusText::_('ALL_USERS') || 
                        $data['userprofile'][$userid][$key]['value'][0] == $value['formatvalue']){
						$unset = false;
						break;
					}
				}
			}
			if($unset){
				unset($data['userprofile'][$userid]);
				$data['total'] = --$data['total'];
			}
		}
		return;
	}
	
	function onBeforeDisplaySearchPanel($infohtml)
	{
		return true;
	}

	function onBeforeDisplayAvailableInfo($availableInfo)
	{
		return true;
	}
	
	function onBeforeDisplayProfileLink($data)
	{
		$mainframe = JFactory::getApplication();

		//Don't run in admin
		if($mainframe->isAdmin())
			return true;
							
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $data);	
		
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		$mainframe = JFactory::getApplication();

		//Don't run in admin
		if($mainframe->isAdmin())
			return true;

		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		return $pluginHandler->triggerInternelPlugin(__FUNCTION__, $toolbar);	
		
	}
	
	function xiusOnAfterLoadList($lists)
	{
		$app = JFactory::getApplication();
		//Don't run in admin
		if($app->isAdmin())
				return true;
				
		require_once (JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php');
		$pluginHandler=XiusFactory::getInstance('pluginhandler','lib');
		return $pluginHandler->xiusOnAfterLoadList($lists);
		
	}
	
	function xiusOnAfterLoadAllInfo($allInfo)
	{
		$app = JFactory::getApplication();

		//Don't run in admin
		if($app->isAdmin())
				return true;
		
		return true;
	}
	
	function onAfterRender()
	{		
		//Don't run in admin
		if(JFactory::getApplication()->isAdmin()){
			return true;
		}

		// Run this function when component is XiUS and
		// task is Search
		$input = JFactory::getApplication()->input;
		
		$option = $input->get('option','');
		$task   = $input->get('task','');
		
		if( !(($option === 'com_xius' || $option =='com_community' ) && $task === 'search'))
	    {  	
			return true;	
		}
			
		$doctype	= JFactory::getDocument()->getType();

		// Only render for HTML output
		if ( $doctype !== 'html' ){
				 return;
			 }
		
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		
		$xiusConfig = XiusFactory::getInstance ('configuration', 'model');
		$params		= $xiusConfig->getOtherParams('config');
		if(!XiusLibCron::_checkCronParams($params)){
			return;
		}
		//get xiuskey for cache update
		$setKey = XiusHelperUtils::getConfigurationParams('xiusKey',0);
		
		// Set url for Cache update
		$url = "index.php?option=com_xius&task=runCron&xiuskey=$setKey";//.JUtility::getToken()."=1";
		$cron = '<img src="'.XiusRoute::_($url).'" />';
		$body = JResponse::getBody();
		$body = str_replace('</body>', $cron.'</body>', $body);
		JResponse::setBody($body);
	}
	
	function onAfterProfileTypeChange($ptype,$result,$userid)
	{		
		if(!$result){
			return true;
		}
		require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';
		//update user data in xius_jsfields_values_table
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'fieldtable.php';
	    return XiusJsfieldTable::updateUserData($userid);
	}
}
