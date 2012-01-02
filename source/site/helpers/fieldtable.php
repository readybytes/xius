<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

class XiusJsfieldTable 
{	
	function _buildQuery() 
	{
		$query['tableAlias'] =	"jsfields_value";
		$query['leftJoin'] 	 = 	"#__xius_jsfields_value";

		//this condition was added for testing purpose 
        //bcz we need to drop xius_jsfields_value table in some testcases while updating cache
		if(!(JFactory::getSession()->get('testmode',false))) 
		{
		  $app = JFactory::getApplication();
          // restrict to drop xius_jsfields_value table from front end cron run
		  if(!$app->isAdmin())
		  	return $query;
		}

		//Drop table if exist
		self::dropTable();
		$filter['pluginType'] = "'Jsfields'";	
		$allJsfieldsInfo 	  = XiusFactory::getInstance ( 'info', 'model' )->getAllInfo($filter,'AND',false);
		
		$createTable  		   = Array();
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
				$dataType = ('date' == $dataType)?'datetime': "varchar(250)";
			}
			$createTable['schema']	 .=", `$columnAlias` "." $dataType";
			$createTable['values'] 	 .= ", GROUP_CONCAT( DISTINCT (if(`field_id`= {$info->key}, `value`, NULL))) AS $columnAlias";
		}
		
		//$query['select'] = preg_replace('/,/', '', $query['select'], 1);
 		$createTable['schema']	 .= ")ENGINE = MyISAM DEFAULT CHARSET=utf8";
		$createTable['values']   .= " FROM `#__community_fields_values`".
						 			" GROUP BY `user_id` )";

		//create table with indexing 
 		self::executeQuery($createTable['schema']);
 		
 		// insert data
 		self::executeQuery($createTable['values']);
		return $query;
	}
	
	/*
	 * Drop xius_jsfields_value table
	 */
	function dropTable()
	{ 
		self::executeQuery("DROP TABLE IF EXISTS `#__xius_jsfields_value` ");
	}
	
	function executeQuery($query)
	{
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}
}