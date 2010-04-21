<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';

class JoomlaView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject)
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$this->setLayout('search');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */	
			
		$fieldHtml = Joomlahelper::getFieldsHTML($calleObject->get('key'));
		
		if(false == $fieldHtml)
			return false;
		//print_r($fieldHtml);
		$this->assign('fieldHtml',$fieldHtml);
		$this->display();
	}
	
}