<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';

class JsFields extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = isComponentExist('com_community',true) ? true : false;
		return $isExist;
	}
	
	
	/*return label + input box html */
	/*public function renderSearchableHtml()
	{
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$filter = array();
		$filter['id'] = $this->key;
		$field = jsfieldshelper::getJomsocialFields($filter);
		if(!$field)
			return parent::renderPluginSearchableHtml();
			
		$fieldHtml = jsfieldshelper::getFieldsHTML($field[0]);
		
		return $this->generateSearchHtml($field[0]->name,$fieldHtml);
	}*/
	
	
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$jsFields = jsfieldshelper::getJomsocialFields();
		
		if(empty($jsFields))
			return false;

		$pluginsInfo = array();
			
		foreach($jsFields as $f){
			if($f->type != 'group')
				$pluginsInfo[$f->id] = $f->name;
		}
		
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value)
	{
		if(!is_array($value)) {
			$columns = $this->getCacheColumns();
			if(!$columns)
				return false;

			if(is_array($columns)) {
				foreach($columns as $c){
					$query->select($c['columnname']);
					$conditions =  $c['columnname']."=".$this->formatValue($value);
					$query->where($conditions);
					return true;
				}
			}
			else{
				$query->select($columns['columnname']);
				$conditions =  $columns['columnname']."=".$this->formatValue($value);
				$query->where($conditions);
				return true;
			}
			
			return false;
		}
		
	}
	
}
