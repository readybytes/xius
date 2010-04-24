<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusBaseView extends JView 
{

	function __construct($filePath)
	{
		$config = array();
		$config['base_path']	 = dirname(dirname($filePath));
		$config['template_path'] = $config['base_path'].DS.'views'.DS.'tmpl'; 
		$config['layout'] 		 = 'search';
		parent::__construct($config);
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
		/*XITODO : unset already exist info */
		$availableInfo = XiusLibrariesInfo::getInfo();
		$calleObject->removeExistingInfo($info,$availableInfo);
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		ob_end_flush();
		$contents = ob_get_contents();
		ob_clean();
		return $contents;
	}
	
	
	function searchHtml($calleObject)
	{
		$inputHtml = '<input type="text" name="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" id="'.$calleObject->get('pluginType').'_'.$calleObject->get('id').'" />';
		
		return $inputHtml;
	}
	
	
}
