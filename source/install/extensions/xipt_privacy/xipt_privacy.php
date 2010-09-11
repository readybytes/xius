<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

class plgXiusxipt_privacy extends JPlugin
{
	var $_debugMode = 0;
		
	function plgXiusxipt_privacy( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	function _loadXipt()
	{				
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';
		if(!JFile::exists($includePath))
			return false;
		
		require_once $includePath;
		return true;
	}
	
	function xiusOnBeforeSaveInfo($postData)
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
	function onBeforeRenderInfoDisplay($params)
	{
		if(!$this->_loadXipt())
			return false;
				
		$privacy['html'] = $this->_xiusGetProfileTypes($params);
		return $privacy['html'];
	}
	
	/*
	 * @will generate the html for XiProfileTypes privacy to be shown
	 */
	function _xiusGetProfileTypes($params)
	{
		$name				= $this->_name;
		$profileTypes		= XiPTLibraryProfiletypes::getProfiletypeArray();
		$param[$name]		= $params['params']->get($name);
		
		if($param[$name] == false || $param[$name] == '')
			unset($param[$name]);
					
		$html 	= $this->getProfileTypeHtml($profileTypes, $name, $param, 'multiple="multiple" size="9"');
		return $html;
	}	
	
	function getProfileTypeHtml($profileType, $name, $param, $attribs = null)
	{
		$xmlPath 	  		= $includePath = JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.'xipt_privacy'.DS.'param.xml';
        $iniPath        	= dirname(__FILE__) . DS .$this->_name.DS.'param.ini';
        $profileTypeData    = JFile::read($iniPath);
        
        if(JFile::exists($xmlPath))
			$config = new JParameter($profileTypeData, $xmlPath);
        else
        	$config = new JParameter('','');
           
        $config->bind($param);
        return $config->render(); 
	}
	
	function xiusOnAfterLoadAllInfo($allInfo, $loginuser=null)
	{
		$app = JFactory::getApplication();
		//Don't run in admin
		if($app->isAdmin())
				return true;
		
		if(!$this->_loadXipt())
			return false;
			
		if($loginuser==null)
			$loginuser=& JFactory::getUser();
			
		$userId	 		 =	$loginuser->id;
		$profileId 		 =	XiPTLibraryProfiletypes::getUserData($userId);
		//$userProfileType =	XiPTLibraryProfiletypes::getProfiletypeName($profileId);
		
		$count = count($allInfo);
		for($i =0 ; $i < $count ; $i++ ){		
			$param = new JParameter('','');
			$param->bind($allInfo[$i]->params);
			$profileTypeInfo= unserialize($param->get($this->_name));
		
			if(!$profileTypeInfo)
				continue;
			
			if(in_array($profileId, $profileTypeInfo) || in_array("0", $profileTypeInfo))
					continue;
					
			unset($allInfo[$i]);		
		}
	return true;
	}
}

