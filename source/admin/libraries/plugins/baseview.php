<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusBaseView extends XiusView 
{

	function __construct($filePath)
	{
		$config = array();
		
		$template	= 'default';
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;		
		$xiusPluginDir = 'xiusplugins';
		
		if(!isset($config['template_path']))
			$config['template_path']	=	array();
				
		$path3 = $xiustemplateBase.DS.JString::strtolower($template).DS.$xiusPluginDir.DS.JString::strtolower($this->getName());
		array_unshift($config['template_path'],$path3);

		$path2 = $xiustemplateBase.DS.JString::strtolower($template).DS.$xiusPluginDir;
		array_unshift($config['template_path'],$path2);
		
		$config['base_path']	 = dirname(dirname($filePath));
		$config['layout'] 		 = 'search';
		$path1 = $config['base_path'].DS.'views'.DS.'tmpl';
		array_unshift($config['template_path'],$path1);		 
		
		parent::__construct($config);
		
		//Little Hack : if template  have a override for us
		global $option, $mainframe;
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
		$availableInfo = XiusLibrariesInfo::getInfo();
		$calleObject->removeExistingInfo($info,$availableInfo);
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}
	
	
	function searchHtml($calleObject,$value='')
	{
		$inputHtml = '<input class="inputbox" type="text" name="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" id="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" value = "'.$value.'"/>';
		
		return $inputHtml;
	}
	
	
}
