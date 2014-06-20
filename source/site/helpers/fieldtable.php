<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusJsfieldTable 
{	
	public static function _buildQuery() 
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
			$createTable['values'] 	 .= ", GROUP_CONCAT( if(`field_id`= {$info->key}, `value`, NULL)) AS $columnAlias";
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
	public static function dropTable()
	{ 
		self::executeQuery("DROP TABLE IF EXISTS `#__xius_jsfields_value` ");
	}
	
	public static function executeQuery($query)
	{
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$db->query();
	}

	/*
	 * update user details whenever profile fields are updated
     */
	public static function updateUserData($userId)
	{
		$db 	= JFactory::getDbo();
		$query 	= "SHOW TABLES LIKE '".$db->getPrefix()."xius_jsfields_value'";
		$db->setQuery($query);
		$tableExist = $db->loadResult(); 
		//Check table exist or not
		if(empty($tableExist)){
			return true;
		}
		
		//get All Jsfields information
		//XiTODO:: Might be effected by Privacy. Please Properly test  it.
		$filter['pluginType'] = "'Jsfields'";	
		$jsInfo = XiusFactory::getInstance ( 'info', 'model' )->getAllInfo($filter,'AND',false);		
		
		//if no information is created of JSFields then do nothing
		if( empty($jsInfo) ) {
			return true;
		}

		/* 
		 * get jsfields value from community_field_value table 
		 * update xius_jsfield_value table
		 */
		$query	  = "SELECT `user_id`";
		foreach($jsInfo as $info){
			$column  = "field_id_{$info->key}";
			$query 	.= ", GROUP_CONCAT( DISTINCT (if(`field_id`= {$info->key}, `value`, NULL))) AS $column";
		}

		$query .= " FROM `#__community_fields_values`".
				  " WHERE `user_id`= $userId ";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$insertQuery = "INSERT INTO `#__xius_jsfields_value` (`user_id`";
		$insertValue = " VALUES( $userId ";
		$onUpdate	 = " ON DUPLICATE KEY UPDATE ";
		
		foreach($jsInfo as $info){
			$column    		 = "field_id_{$info->key}";
			$insertQuery	.= ", `$column`";
			if(is_numeric($result[0]->$column)){
				$insertValue	.= ", {$result[0]->$column} ";
				$onUpdate 		.= ", `$column` = {$result[0]->$column} ";
				continue;
			}
			//handle special charaters
			$column_value	 = (XIUS_JOOMLA_15 || XIUS_JOOMLA_16)?$db->getEscaped($result[0]->$column):$db->escape($result[0]->$column);
			$insertValue	.= ", '{$column_value}' ";
			$onUpdate 		.= ", `$column` = '{$column_value}' ";
		}
		$onUpdate = preg_replace('/,/', '',$onUpdate, 1);
		$query    = $insertQuery.")".$insertValue.")".$onUpdate;
		$db->setQuery($query);
		if(!$db->query()){
			JFactory::getApplication()->enqueueMessage("XiUS JSfield value doesn't update. Please say to your site administrator");	
		}
		
		//for instant cache updation write "true" in if condition
		if(false)
		{
			
		 	   $query = "SHOW TABLES LIKE '".$db->get('_table_prefix')."xius_cache'";
               $db->setQuery($query);
               if($db->loadResult()){
                       
                       $query = "INSERT INTO `#__xius_cache`(`userid`)
                                         VALUE ($userId)
                                         ON DUPLICATE KEY UPDATE `userid`= $userId";
                       $db->setQuery($query);
                       $db->query();
               }
		}
		return true;
	}
}