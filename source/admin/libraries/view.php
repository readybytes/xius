<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
/**
 */

abstract class XiusView extends JView
{
	/* Will be set by controller*/
	public $_model 			= null;
	public $_form 			= null;
	
	public $_xiurl 			= null;
	//public $_isExternalUrl  = false;
	
	function __construct($config = array())
	{		
		$template	= XiusHelpersUtils::getConfigurationParams('xiusTemplates','default');
		// override the template path, so that default
		// templates will be picked from here
		//XITODO : we can add here multiple templates, so from global params
		// we will define the directory here
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;

		if(!isset($config['template_path']))
			$config['template_path']	=	array();

		//Always add base template path first and actual view path second
		//base _addPath function will automatically
		//give preference to last given path

		//VERY IMP : These order should be maintained
		$path1 = $xiustemplateBase.DS.JString::strtolower($template).DS.JString::strtolower($this->getName());
		array_unshift($config['template_path'],$path1);

		$path2	=	$xiustemplateBase.DS.JString::strtolower($template);
		array_unshift($config['template_path'],$path2);
		
		parent::__construct($config);
	}
	
	/*
	 * Collect prefix auto-magically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)View/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiView::getPrefix() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}
	
	
	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming	 
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/View(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
	
	function displayResult($from,$list='',$tmpl)
	{
		$data = array(array());
		XiussiteHelperResults::_getInitialData($data);
		XiussiteHelperResults::_getUsers($data);
		XiussiteHelperResults::_getTotalUsers($data);
		XiussiteHelperResults::_createUserProfile($data);
		XiussiteHelperResults::_getAppliedInfo($data);
		XiussiteHelperResults::_getAvailableInfo($data);

		$document = JFactory::getDocument();
        if(!empty($list) && !empty($list->name))
			$document->setTitle(XiusText::_($list->name));
		else
			$document->setTitle(XiusText::_('Search Result'));

		//collect confuguration params
		$xiusSlideShow  		= xiusHelpersUtils::getConfigurationParams('xiusSlideShow','none');
		$joinHtml['enable']  	= xiusHelpersUtils::getConfigurationParams('xiusEnableMatch',1);
		$joinHtml['defultMatch']= xiusHelpersUtils::getConfigurationParams('xiusEnableMatch','All');
		$loadJquery				= xiusHelpersUtils::getConfigurationParams('xiusLoadJquery',1);
		// load jquery package

		$this->assignRef('loadJquery', $loadJquery);
		$this->assignRef('xiusSlideShow', $xiusSlideShow);
		$this->assignRef('joinHtml', $joinHtml);
		$this->assignRef('users', XiussiteHelperProfile::getUserProfileData($data['users']));
		
		// get the list id for save list
		$listid=0;
		if(!empty( $list )){
			if(isset($list->id))
				$listid = $list->id;
			}
		
		$toolbar =XiussiteHelperToolbar::getAdminToolbar($listid,$from,$this->getXiUrl());
		$this->assignRef('toolbar',$toolbar);
		//calculate data for these users

		// trigger event onBeforMiniProfileDisplae
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeMiniProfileDisplay', array( &$data ) );
		
		$this->assignRef('userprofile', $data['userprofile']);
		$this->assignRef('sortableFields', $data['sortableFields']);
		$this->assignRef('pagination', $data['pagination']);
		$this->assign('total', $data['total']);
		$this->assign('appliedInfo', $data['appliedInfo']);
		$this->assign('availableInfo', $data['availableInfo']);

		$this->assign('sort', $data['sortId']);
		$this->assign('dir', $data['dir']);
		$this->assign('join', $data['join']);

		$this->assign('list', $list);
		$this->assign('submitUrl', $this->getXiUrl());
		$this->assign('task', $from);
		$this->assign('view', $this->getName());
		$this->display($tmpl);
	}

	function display($tmpl = null)
	{
		// set proper URI
		if($this->_xiurl === null)
		{
			//then set something we desire
			// XITODO : if still $this->_xiurl  iss not set then what to do
			$this->_xiurl = $this->getXiUrl();
		}
		
		$this->assign('submitUrl', $this->getXiUrl());
		return parent::display($tmpl);
	}
	
	
	public function setXiUrl($vars)
	{
		if($this->_xiurl)
			return true;

		$currentURI =& JURI::getInstance();	
		
		foreach($vars as $key => $val){
		
			if($val === null){	
				// del the var from url 
				// these will not be used as URL for posting the form		
				$currentURI->delVar($key);
				continue;
			}		
			/*
		 	* if external url is true, it means xius is triggred from othe components
		 	* so set two var xiusview and xiustask
		 	*/
			$currentURI->setvar($key,$val);		
		}
		
		/*
		 * always set usexius to true so that xius will be integrated with jom social 
		 */
		$currentURI->setvar('usexius',1);
		
		$this->_xiurl = $currentURI->toString();
		return;
	}
	
	public function getXiUrl()
	{
		return $this->_xiurl;
	}
	
	// XITODO : UNIT Test case for the following function
	public function loadAssets($type,$filename)
	{
		$template	= XiusHelpersUtils::getConfigurationParams('xiusTemplates','default');
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;	
		static $path = null;
		
		if($path === null || !array_key_exists($type, $path)){
			$path[$type] =array();
			
			// load joomla template path
			$templateDir = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate();
			$path1 = $templateDir.DS.'com_xius'.DS.'assets'.DS.JString::strtolower($type);
			array_push($path[$type],$path1);
			
			// load xius template path
			$path2	=	$xiustemplateBase.DS.$template.DS.'assets'.DS.JString::strtolower($type);
			array_push($path[$type],$path2);
			
			// load common path of assets
			$path3 	= XIUS_PATH_SITE_ASSET.DS.JString::strtolower($type);
			array_push($path[$type],$path3);
		}
		
		$assetsPath = JPath::find($path[$type], $filename);
		if($assetsPath === false){
			return JError::raiseError( 500, 'Assets "' . $filename . '" not found' );
		}
		
		$assetsPath = JString::str_ireplace(JPATH_ROOT,JURI::base(),$assetsPath);
		$document =& JFactory::getDocument();
		
		switch($type){
			case 'css':	$document->addStyleSheet($assetsPath);
						break;
			case 'js' : $document->addScript($assetsPath);
						break;
		}
		return true;
	}
}