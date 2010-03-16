<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class JsFields extends XiusBase
{

	function __construct($debugMode)
	{
		parent::__construct(__CLASS__,$debugMode);
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = isComponentExist('com_community',true) ? true : false;
		return $isExist;
	}
	
	
	/*return label + input box html */
	public function renderPluginSearchableHtml()
	{
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		$filter = array();
		$filter['id'] = $this->key;
		$field = jsfieldshelper::getJomsocialFields($filter);
		if(!$field)
			return parent::renderPluginSearchableHtml();
			
		$fieldHtml = jsfieldshelper::getFieldsHTML($field[0]);
		
		return $this->generateSearchHtml($field[0]->name,$fieldHtml);
	}
	
}
