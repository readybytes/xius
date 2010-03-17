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
	
}
