<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class JsFieldsView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml()
	{
		$this->setLayout('search');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		$filter = array();
		$filter['id'] = $this->key;
		$field = jsfieldshelper::getJomsocialFields($filter);
		if(!$field) {
			/*XITODO : return false , function does not exist over view */		
			return parent::renderPluginSearchableHtml();
		}
			
		$fieldHtml = jsfieldshelper::getFieldsHTML($field[0]);
		
		$this->assign('fieldHtml',$fieldHtml);
		$this->display();
	}
}
