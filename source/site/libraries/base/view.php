<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.application.component.view' );
/**
 */

class XiusView extends JViewLegacy
{
	/* Will be set by controller*/
	public $_model 			= null;
	public $_form 			= null;
	
	public $_xiurl 			= null;
	//public $_isExternalUrl  = false;

	static $_submenus = array('cpanel', 'configuration', 'info','list');

	/*
	 * Set default Path Array according to Priority.
	 * (Also include template overwritting)
	 */
	function __construct($config = array())
	{		
		if(JFactory::getApplication()->isAdmin())
			return parent::__construct($config);
		
		$template	= XiusHelperUtils::getConfigurationParams('xiusTemplates','default');

		if(!isset($config['template_path']))
			$config['template_path']	=	array();

		//Always add base template path first and actual view path second
		//base _addPath function will automatically
		//give preference to last given path

		//VERY IMP : These order should be maintained
		$path  = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate().DS.'html'.DS.'com_xius';
		$path1 = XIUS_PATH_TEMPLATE.DS.JString::strtolower($template).DS.JString::strtolower($this->getName());
		$path2 = XIUS_PATH_TEMPLATE.DS.JString::strtolower($template);
		
		//Higest Priority Path. ($path > $path1 > $path2)
		//$path, Its Joomla Template Path(when add our component path)
		//$path(We can also perform template overwirtting through this path)
		//$path1:: Template Path of XiUS			
		//$path2:: Template Path of "XiUS Internal-Plugin"
		parent::__construct($config);
		array_unshift($config['template_path'], $path1, $path2,$path);
		parent::_addPath('template', $config['template_path']);
	}
	
	/*
	 * Collect prefix auto-matically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		XiusError::assert(preg_match('/(.*)View/i', get_class($this), $r), "XiusView::getPrefix() : Can't get or parse class name.");

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}

	
	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming	 
	 */
	function getName()
	{
		if(empty($this->_name))
		{
			$r = null;
			XiusError::assert(preg_match('/View(.*)/i', get_class($this), $r), "XiusView::getPrefix() : Can't get or parse class name.");
			$this->_name = strtolower( $r[1] );
		}
		return $this->_name;
	}
	
	function displayResult($from,$list='',$tmpl)
	{
		$data = array(array());
		XiusHelperResults::_getInitialData($data);
		XiusHelperResults::_getUsers($data);
		XiusHelperResults::_getTotalUsers($data);
		XiusHelperResults::_createUserProfile($data);
		XiusHelperResults::_getAppliedInfo($data);
		XiusHelperResults::_getAvailableInfo($data);

		$document = JFactory::getDocument();
		
        if(!empty($list) && !empty($list->name))
			$document->setTitle($list->name);
		else
			$document->setTitle(XiusText::_('SEARCH_RESULT'));

		//collect confuguration params
		$xiusSlideShow  		= XiusHelperUtils::getConfigurationParams('xiusSlideShow','none');
		$joinHtml['enable']  	= XiusHelperUtils::getConfigurationParams('xiusEnableMatch',1);
		$joinHtml['defultMatch']= XiusHelperUtils::getConfigurationParams('xiusDefaultMatch','AND');
		$loadJquery				= XiusHelperUtils::getConfigurationParams('xiusLoadJquery',1);
		// load jquery package

		$this->assignRef('loadJquery', $loadJquery);
		$this->assignRef('xiusSlideShow', $xiusSlideShow);
		$this->assignRef('joinHtml', $joinHtml);
		$usreProfileData = XiusHelperProfile::getUserProfileData($data['users']);
		$this->assignRef('users', $usreProfileData);
		
		// get the list id for save list
		$listid=0;
		if(!empty( $list ) && isset($list->id)){
				$listid = $list->id;
			}
		
		//calculate data for these users

		// trigger event onBeforMiniProfileDisplae
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeMiniProfileDisplay', array( &$data ) );
		$toolbar = $this->_setAdminToolbar($listid,$from);
		$this->assign('xiusToolbar', $toolbar);
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

	/*
	 * this function will return the admin toolbar content
	 */
	function _setAdminToolbar($listid, $task, $option = null)
	{	
		$args[]= array();
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayResultToolbar', array($args) );
			
		static $toolbarAdded = null;		
		if($toolbarAdded != null)
			return;
		
		$toolbarAdded = true;
		$user = JFactory::getUser();		
		
		// if logged in user's user type is in list creator user type 
		//then he will be having the option of saving and exporting list	
		if(XIUS_JOOMLA_15)	
			$listCreator = unserialize(XiusHelperUtils::getConfigurationParams('xiusListCreator','a:1:{i:0;s:19:"Super Administrator";}'));
 		else
			$listCreator = unserialize(XiusHelperUtils::getConfigurationParams('xiusListCreator','a:1:{i:0;s:19:"Super Users";}'));
		if($option === null){				
			$option = JFactory::getApplication()->input->get('option','com_xius');
		}
					
		/*
		 * get toolbar option for save list
		 */
		if(XiusHelperList::isAccessibleToUser($user,$listCreator)){  			
  			$url 		= XiusRoute::_('index.php?option='.$option.'&view=list&task=saveas&usexius=1&tmpl=component&listid='.$listid,false);
 			$buttonMap 	= XiusFactory::getModalButtonObject('savelist','SAVE_LIST',$url,XIUSLIST_IFRAME_WIDTH,XIUSLIST_IFRAME_HEIGHT);
  			$this->assign('buttonMap',$buttonMap); 			
 			
  			$html	= $this->loadTemplate('toolbar_savelist'); 		
 			return XiusHelperToolbar::addToAdminToolbar('savelist',$html); 			
 		} 		
 		
  		return XiusHelperToolbar::addToAdminToolbar();
  	}	
	
	public function setXiUrl($vars)
	{
		if($this->_xiurl)
			return true;

		$currentURI = JURI::getInstance();	
		
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
		XiusHelperUtils::loadJomsJquery();
		$template	= XiusHelperUtils::getConfigurationParams('xiusTemplates','default');
		static $path = null;
		
		if($path === null || !array_key_exists($type, $path)){
			$path[$type] =array();
			
			// load joomla template path
			$templateDir = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate();
			//css or js is specified by templates
			$path1 = $templateDir.DS.'html'.DS.'com_xius'.DS.'assets'.DS.JString::strtolower($type);
			// load xius template path
			$path2	=	XIUS_PATH_TEMPLATE.DS.$template.DS.'assets'.DS.JString::strtolower($type);
			// load common path of assets
			$path3 	= XIUS_PATH_SITE_ASSET.DS.JString::strtolower($type);
			array_push($path[$type],$path1, $path2, $path3);
		}
		
		$assetsPath = JPath::find($path[$type], $filename);
		XiusError::assert($assetsPath,  'Assets "' . $filename . '" not found');

		$assetsPath = XiusHelperUtils::XIUS_str_ireplace(XIUS_ROOT_PATH,'',$assetsPath);				
		$assetsPath = XiusHelperUtils::getUrlpathFromFilePath($assetsPath);
		$assetsPath = JURI::base().ltrim($assetsPath, '/');
		
		$document 	= JFactory::getDocument();
		switch($type){
			case 'css':	$document->addStyleSheet($assetsPath);
						break;
			case 'js' : $document->addScript($assetsPath);
						break;
		}
		return true;
	}
	
	
	/*
	 * Backend base view 
	 * 
	 * 
	 */
	static function addSubmenus($menu=null)
	{
		if($menu !== null){
			self::$_submenus[] = $menu;
		}
		return self::$_submenus;
	}
	
	static function _addSubMenu($menu, $selMenu,$comName='com_xius')
	{
		$selected 	= ($menu==$selMenu);
		$link 		= "index.php?option=".$comName."&view=$menu";
		$title 		= XiusText::_(JString::strtoupper($menu));
		JSubMenuHelper::addEntry($title,$link, $selected);
	}
	
	public function display($tpl = null)
	{
		if(JFactory::getApplication()->isSite()){
			// set proper URI
			if($this->_xiurl === null)
			{
				//then set something we desire
				// XITODO : if still $this->_xiurl  iss not set then what to do
				$this->_xiurl = $this->getXiUrl();
			}
			// XiTODO:: Clean This
			$this->assign('submitUrl', $this->_xiurl);
			return parent::display($tpl);
		}
		
		$this->_setToolBar();
	
		foreach(self::$_submenus as $submenu)
		{
			self::_addSubMenu($submenu,$this->_name);
		}
	
		$output = $this->loadTemplate($tpl);
	
		if ($output instanceof Exception)
		{
			return $output;
		}
	
		$header = $this->getHeader();
		$footer = $this->getFooter();
	
		echo "<div id='xius_header' class='clearfix'>".$header."</div><div id='xius_body' class='clearfix'>".$output."</div><div id='xius_footer' class='clearfix'>".$footer."</div>";
	}
	
	function setToolBar()
	{
		return true;
	}
	
	function _setToolBar()
	{
		// Set the titlebar text
		JToolBarHelper::title( XiusText::_(strtoupper($this->_name)), $this->_name );
	
		$this->setToolBar();
	}
	
	function getHeader()
	{
		return '<div></div>';
	}
	
	function getFooter()
	{
		ob_start();
		include_once(XIUS_COMPONENT_PATH_ADMIN.DS.'views'.DS.'cpanel'.DS.'tmpl'.DS.'default_footermenu.php');
		$footer = ob_get_contents();
		ob_clean();
	
		return $footer;
	}
	
}
