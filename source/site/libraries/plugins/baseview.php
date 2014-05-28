<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusBaseView extends XiusView 
{

	function __construct($filePath)
	{
		$config = array();
		
		$template	= XiusHelperUtils::getConfigurationParams('xiusTemplates','default');
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;		
		$xiusPluginDir = 'xiusplugins';
		
		if(!isset($config['template_path']))
			$config['template_path']	=	array();

		$templateDir = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate();
		
		//XITODO : needs improment
		$path4 = $templateDir.DS.'html'.DS.'com_xius'.DS.$xiusPluginDir.DS.JString::strtolower($this->getName());
		array_unshift($config['template_path'],$path4);
		 
		$path3 = $xiustemplateBase.DS.JString::strtolower($template).DS.$xiusPluginDir.DS.JString::strtolower($this->getName());
		array_unshift($config['template_path'],$path3);

		$path2 = $xiustemplateBase.DS.JString::strtolower($template).DS.$xiusPluginDir;
		array_unshift($config['template_path'],$path2);
		
		$config['base_path']	 = dirname(dirname($filePath));
		$config['layout'] 		 = 'default';
		$path1 = $config['base_path'].DS.'views'.DS.'tmpl';
		array_unshift($config['template_path'],$path1);		 
		
		parent::__construct($config);
		
		//Little Hack : if template  have a override for us
		$option    = JRequest::getVar('option');
		$mainframe = JFactory::getApplication();
		if($option == 'com_xius')
		{
			$fallback = JPATH_BASE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_xius'.DS.$this->getName();
			$this->_addPath('template', $fallback);
		}
		else
			$this->_addPath('template', $config['template_path'] );
		
	}
	
	
	/*
	 * We need to override xiusview behaviour as they differ in
	 * 	 
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/(.*)View/i', get_class($this), $r)) {
				JError::raiseError (500, "Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
	
	function rawDataHtml(XiusBase $calleObject)
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$this->setLayout('rawdata');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		
		$info = $calleObject->getAvailableInfo();
		/*unset already exist info */
		$availableInfo = XiusLibInfo::getInfo();
		$calleObject->removeExistingInfo($info,$availableInfo);
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}
	
	
	function searchHtml($calleObject,$value='')
	{	
		$this->assign('calleObject' , $calleObject);
		$this->assign('value' , $value);
		
		ob_start();
		$this->display('base_search');
				
		$contents = ob_get_clean();
		return $contents;
		
		$inputHtml = '<input class="inputbox" type="text" name="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" id="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" value = "'.$value.'"/>';
		
		return $inputHtml;
	}
	
	public function loadAssets($type,$filename)
	{
		$template	= XiusHelperUtils::getConfigurationParams('xiusTemplates','default');
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;	
		static $path = null;
		
		if($path === null || !array_key_exists($type, $path)){
			$path[$type] =array();
			
			// load joomla template path
			$templateDir = JPATH_THEMES.DS.JFactory::getApplication()->getTemplate();
			$path1 = $templateDir.DS.'html'.DS.'com_xius'.DS.'xiusplugins'.DS.'assets'.DS.JString::strtolower($type);
			array_push($path[$type],$path1);
			
			// load xius template path
			$path2	=	$xiustemplateBase.DS.$template.DS.'xiusplugins'.DS.'assets'.DS.JString::strtolower($type);
			array_push($path[$type],$path2);
			
			// load common path of assets
			$path3 	= XIUS_PATH_SITE_ASSET.DS.JString::strtolower($type);
			array_push($path[$type],$path3);
		}
		
		$assetsPath = JPath::find($path[$type], $filename);
		if($assetsPath === false){
			return JError::raiseError( 500, 'Assets "' . $filename . '" not found' );
		}
		
		$assetsPath = XiusHelperUtils::XIUS_str_ireplace(JPATH_ROOT,JURI::base(),$assetsPath);
		$document = JFactory::getDocument();
		
		switch($type){
			case 'css':	$document->addStyleSheet($assetsPath);
						break;
			case 'js' : $document->addScript($assetsPath);
						break;
		}
		return true;
	}	

	public function display($tpl = null)
	{
		// set proper URI
		if($this->_xiurl === null)
		{
			//then set something we desire
			// XITODO : if still $this->_xiurl  iss not set then what to do
			$this->_xiurl = $this->getXiUrl();
		}
		// XiTODO:: Clean This
		$this->assign('submitUrl', $this->_xiurl);
		
		$output = $this->loadTemplate($tpl);

		if ($output instanceof Exception)
		{
			return $output;
		}
	
		echo $output;
	}
}
