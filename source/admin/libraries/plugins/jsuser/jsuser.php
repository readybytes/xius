<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).DS.'jsuserhelper.php';

class Jsuser extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = XiusHelpersUtils::isComponentExist('com_community',true) ? true : false;
		return $isExist;
	}
	
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			 
		$fields = Jsuserhelper::getJomsocialFields();
		
		if(empty($fields))
			return false;

		$pluginsInfo = array();
			
		foreach($fields as $k => $v){
		//	if($k == '' || $k == 'password'
			//		|| $k == 'activation' || $k == 'sendEmail')
				//continue;
				
			$pluginsInfo[$k] = JText::_($k);
		}
		return $pluginsInfo;
	}
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		$db = JFactory::getDBO();
		if(is_array($value))
			return false;

		//get all cache columns 
		$columns = $this->getTableMapping();
		
		if(!$columns)
			return false;
			
		foreach($columns as $c){
			$conditions =  $db->nameQuote($c->cacheColumnName).' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
			
			if($this->key == 'posted_on')
				$conditions = "DATE_FORMAT(".$db->nameQuote($c->cacheColumnName).", '%d-%m-%Y') ".$operator.' '.$db->Quote($this->formatValue($value));
				
			$query->where($conditions,$join);
		}		
		return true;
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
		
		$tableMapping = $this->getTableMapping();
		
		foreach( $tableMapping as $tm){
			$query->select( " {$tm->tableAliasName}.{$tm->originColumnName} "
							." as {$tm->cacheColumnName} "
						  );
			$query->leftJoin( " {$tm->tableName}  as {$tm->tableAliasName}   "
							 ." ON ( {$tm->tableAliasName}.`userid` = juser.`id` ) "
							);
		}
	}
	
	function getTableMapping()
	{
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		$object->tableAliasName 	= "communityusers{$this->key}_$count";
		$object->originColumnName	= $this->key;
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec 		= $this->getCacheSqlSpec($this->key);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getInfoName()
	{
		//$filter = array();
		$filter = $this->key;
		$fieldInfo = Jsuserhelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo;
			
		return false;
	}
	
	function getCacheSqlSpec($key)
	{
		if($key == 'posted_on')
			return 'datetime NOT NULL'; 
		
		if($key == 'userid')
			return 'int(21) NOT NULL';
			
		return parent::getCacheSqlSpec($key);
	}
	
	
	/*function formatValue($value)
	{
		if($this->key == 'registerDate')
		{
			//$values = array();
			$value = split('-',$value);
		}
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		return $formatvalue;
	}*/
	
	
	/* formatting displaying output */
	public function _getFormatData($value)
	{
		if($this->key != 'posted_on')
			return parent::_getFormatData($value);
		
		$value = split('-',$value);
		$finalvalue = '';
			
		if(is_array($value)){
			if( empty( $value[0] ) || empty( $value[1] ) || empty( $value[2] ) )
				$finalvalue = '';
			else {
				if(JString::strlen($value[0]) == 4){
					$year	= intval($value[0]);
					$month	= intval($value[1]);
					$day	= intval($value[2]);
				}
				else{
					$day	= intval($value[0]);
					$month	= intval($value[1]);
					$year	= intval($value[2]);
				}
				
				$day 	= !empty($day) 		? $day 		: 1;
				$month 	= !empty($month) 	? $month 	: 1;
				$year 	= !empty($year) 	? $year 	: 1970;
				
				$finalvalue	= $day . '-' . $month . '-' . $year;
			}
		}
			
		return $finalvalue;	
	}
}
