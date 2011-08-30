<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';

class JsfieldsBase extends XiusBase
{

	function __construct()
	{		
		parent::__construct(get_class($this));
	}
	
	
	function isAllRequirementSatisfy()
	{
		/*it will return false if community component does not exist */
		$isExist = XiusHelperUtils::isComponentExist('com_community',true) ? true : false;
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
	

	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false)
			return false;
		
		$db = JFactory::getDBO();
		$columns = $this->getTableMapping();
		if(!$columns)
			return false;
			
		if(!is_array($columns)) 
			return false;
			
		$fType = Jsfieldshelper::getFieldType($this->key);
		
		Jsfieldshelper::changeValueFormat($value, $fType);
		
		if(!is_array($value)){		
			foreach($columns as $c){
				if(JString::strtolower($fType) == 'text' || $operator == XIUS_LIKE)
					$conditions =  $db->nameQuote($c->cacheColumnName).' '.XIUS_LIKE.' '.$db->Quote('%'.$this->formatValue($value).'%');
				else
					$conditions =  $db->nameQuote($c->cacheColumnName).' '.$operator.' '.$db->Quote($this->formatValue($value));
				$query->where($conditions,$join);
			}
			return true;			
		}
		
		if(is_array($value)){			
				foreach($columns as $c){
					$conditions = '';
					$count = 0;
					foreach($value as $v){
						$conditions .= $count ? ' AND ' : ' ( ';
						$conditions .= ''.$db->nameQuote($c->cacheColumnName).' LIKE '.$db->Quote('%'.$this->formatValue($v).'%');
						$count++;
						//$query->where($conditions);
					}
					
					$conditions .= ' ) ';
					//$query->select($c['columnname']);
					$query->where($conditions,$join);
				}
				
				return true;			
			}	
		return false;		
	}
	
	/*
	 * return the information related to the source table  
	 */
	function getTableMapping()
	{
		
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);

		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= "`#__xius_jsfields_value`";//'`#__community_fields_values`';
		$object->tableAliasName 	= "jsfields_value";//strtolower($this->pluginType).$this->key.'_'.$count;
		$object->originColumnName	= "`field_id_{$this->key}`";//'value';
		$object->cacheColumnName	= strtolower($this->pluginType).$this->key.'_'.$count;
		$object->cacheSqlSpec		= $this->getCacheSqlSpec($fieldInfo);
		$object->cacheLabelName		= $this->labelName;
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	function getUserData(XiusQuery &$query)
	{
		static $queryRequired = true;
		
		$tableMapping = $this->getTableMapping();
		foreach( $tableMapping as $tm)
			$query->select(" {$tm->tableAliasName}.{$tm->originColumnName} as {$tm->cacheColumnName} ");
			
		if($queryRequired)
		{
			self::_getUserData($query);
			$queryRequired = false;
		}
		
//		$query->select('juser.`id` as userid');
//		$query->from('`#__users` as juser');
//		$tableMapping = $this->getTableMapping();
//		foreach( $tableMapping as $tm){
//			$query->select(" {$tm->tableAliasName}.{$tm->originColumnName} as {$tm->cacheColumnName} ");
//			$query->leftJoin(" {$tm->tableName} as {$tm->tableAliasName} ON "
//								." ( {$tm->tableAliasName}.`user_id` = juser.`id` "
//								." AND  {$tm->tableAliasName}.`field_id` = {$this->key} "
//								." ) "
//							);
//		}		
	}
	
	/* at the time of saving data into database durin search also */
	function formatValue($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(empty($fieldInfo))
			return $value;
		
		if($fieldInfo[0]->type == 'checkbox' || $fieldInfo[0]->type == 'list')
			return $value;


		if($fieldInfo[0]->type == 'date' || $fieldInfo[0]->type == 'birthdate')
		{
			//$splitValue = split('-',$value);
			$splitValue = explode('-',$value);
			if( count($splitValue) < 3)
				return $value;
			$value		= $splitValue;
		}

		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::formatData($value);		
		}
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		return $formatvalue;
	}
	
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo[0]->name;
			
		return false;
	}
	
	
	/*Function will format data in display form on mini profile	 */
	public function _getFormatData($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		/*XITODO : Cache jomsocial fields */
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);

		if(is_array($value) && $value!=array())
				$value = implode(",",$value);
		
		if(empty($fieldInfo))
			return $value;
			
		if($fieldInfo[0]->type == 'date' || $fieldInfo[0]->type == 'birthdate'){
			$db 	= JFactory::getDBO(); 
			$query	= 'SELECT DATE_FORMAT('.$db->Quote($value).', "%d-%m-%Y") AS FORMATED_DATE';
			$db->setQuery($query);
			$result= $db->loadResult();
			return ($result == "00-00-0000") ? '' : $result ;
		}		
		
		if($fieldInfo[0]->type == 'profiletypes'){
			require_once( XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'profiletype.php' );
			return ProfiletypesHelper::getFieldData($value);			
		}
		
		require_once( JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'profile.php' );
		//$formatvalue = CProfileLibrary::getFieldData($fieldInfo[0]->type,$value);
		// for JS 2.2.1 not tested with 2.2.0
		$formatvalue = CProfileLibrary::formatData($fieldInfo[0]->type,$value);
		//$formatvalue = CProfileLibrary::getFieldData($fieldInfo[0]);
		return $formatvalue;
	}
	
	public function _getFormatAppliedData($value)
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = Jsfieldshelper::getJomsocialFields($filter);
		
		if(!empty($fieldInfo) && $fieldInfo[0]->type == 'birthdate'){
			Jsfieldshelper::changeValueFormat($value, $fieldInfo[0]->type);
			return $value;
		}
		
		if($fieldInfo != array() && $fieldInfo[0]->type == 'date')
			return $value;
		
		return $this->_getFormatData($value);
	}
	
	function getCacheSqlSpec($fieldInfo){
		$specification = 'varchar(250) NOT NULL';
		
		if(!empty($fieldInfo) && ($fieldInfo[0]->type === 'date'|| $fieldInfo[0]->type === 'birthdate'))
			$specification = "datetime NOT NULL";
			
		return $specification;	
	}
	
	function _getUserData(XiusQuery &$query)
	{
		$filter['pluginType'] = "'Jsfields'";	
		$allInfo = XiusFactory::getInstance ( 'info', 'model' )->getAllInfo($filter,'AND',false);
		$queryData = self::_buildQuery($allInfo);

		//$query->select($queryData['select']);
		$query->leftJoin("`{$queryData['leftJoin']}` AS {$queryData['tableAlias']}
							ON 
							juser.`id` = {$queryData['tableAlias']}.`user_id`");			
	}
	
	function _buildQuery($allJsfieldsInfo) 
	{
		$query['tableAlias']=	"jsfields_value";
		//$query['select']	= 	"";
		$query['leftJoin'] 	= 	"#__xius_jsfields_value";
		
		//Drop table if exist
		self::executeQuery("DROP TABLE IF EXISTS `#__xius_jsfields_value` ");
		
		$createTable  = Array();
		$createTable['schema'] = "CREATE TABLE `#__xius_jsfields_value`( `user_id` int(21) NOT NULL PRIMARY KEY ";
		$createTable['values'] = "INSERT INTO `#__xius_jsfields_value` (SELECT `user_id`";
		$count = 0;
		foreach($allJsfieldsInfo as $info){
			$columnAlias 	  = "field_id_{$info->key}";
			//$cacheColumnName  = strtolower($info->pluginType).$info->key."_$count";
			//$query['select'] .= ", {$query['tableAlias']}.`$columnAlias` AS $cacheColumnName ";
			$dataType = Jsfieldshelper::getFieldType($info->key);
			if('text' == $dataType || 'textarea' == $dataType){
				$dataType = 'text';
			}
			else{
				$dataType = ('date' == $dataType)?'date': "varchar(250)";
			}
			$createTable['schema']	 .=", `$columnAlias` "." $dataType";
			$createTable['values'] 	 .= ", GROUP_CONCAT( DISTINCT (if(`field_id`= {$info->key}, `value`, NULL))) AS $columnAlias";
		}
		
		//$query['select'] = preg_replace('/,/', '', $query['select'], 1);
 		$createTable['schema']	 .= ")";
		$createTable['values']   .= " FROM `#__community_fields_values`".
						 			" GROUP BY `user_id` )";

		//create table with indexing 
 		self::executeQuery($createTable['schema']);
 		
 		// insert data
 		self::executeQuery($createTable['values']);
		return $query;
	}
	
	function executeQuery($query)
	{
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}
	
	
}
