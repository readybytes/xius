<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';

class Joomla extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$fields = Joomlahelper::getJoomlaFields();
		
		if(empty($fields))
			return false;

		$pluginsInfo = array();
			
		foreach($fields as $k => $v){
			if($k == 'params' || $k == 'password')
				continue;
				
			$pluginsInfo[$k] = JText::_($k);
		}
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		$db = JFactory::getDBO();
		if(!is_array($value)) {
			$columns = $this->getCacheColumns();
			if(!$columns)
				return false;

			if(is_array($columns)) {
				foreach($columns as $c){
					//$query->select($c['columnname']);
					$conditions =  $db->nameQuote($c['columnname']).$operator."'".$this->formatValue($value)."'";
					$query->where($conditions,$join);
					return true;
				}
			}
			else{
				//$query->select($columns['columnname']);
				$conditions =  $db->nameQuote($columns['columnname']).$operator."'".$this->formatValue($value)."'";
				$query->where($conditions,$join);
				return true;
			}
			
			return false;
		}
		
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('joomlauser'.$this->getCacheColumnName().'.'.$this->getCacheColumnName().' as '.strtolower($this->pluginType).$this->getCacheColumnName());
		
		$query->leftJoin('`#__users` as joomlauser'.$this->getCacheColumnName().' ON ( joomlauser'.$this->getCacheColumnName().'.`id` = juser.`id` )' );
	}
	
	
	function getInfoName()
	{
		//$filter = array();
		$filter = $this->key;
		$fieldInfo = Joomlahelper::getJoomlaFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo;
	}
	
}
