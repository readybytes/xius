<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'cbuilder'.DS.'cbuilderhelper.php';

class Cbuilder extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$fields = Cbuilderhelper::getCBFields();
		
		if(empty($fields))
			return false;
		//print_r(var_export($fields));	
		$pluginsInfo = array();
			
		foreach($fields as $f){
			$pluginsInfo[$f->fieldid] = $f->name;
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
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.*');
		$query->from('`#__users` as juser');
	}
	
}
