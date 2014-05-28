<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class ProximityDatabaseEncoder extends XiusProximityEncoder 
{
	var $params = '';
	
	function __construct($params)
	{
		$this->params = $params;
	}
	
	function getTableMapping()
	{

	    $table = $this->params->get('xius_proximity_table','#__xius_proximity');
		$originalLatColumn  = $this->params->get('xius_proximity_lat_column','latitude');
		$originalLongColumn = $this->params->get('xius_proximity_long_column','longitude');

		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_latitude";
		$object->originColumnName	= $originalLatColumn;
		$object->cacheColumnName	= "proximity_db_latitude_$count";
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName		= XiusText::_('LATITUDE');
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_longitude";
		$object->originColumnName	= $originalLongColumn;
		$object->cacheColumnName	= 'proximity_db_longitude_'.$count;
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName 	= XiusText::_('LONGITUDE');
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}	
	
	public function getDatabaseCloumnName()
	{
		$column['city'] 	= $this->params->get("xius_proximity_city_column",'');
		$column['zipcode']  = $this->params->get("xius_proximity_zipcode_column",'');
		$column['country'] 	= $this->params->get("xius_proximity_country_column",'');		
		$column['state']	= $this->params->get("xius_proximity_state_column",'');
		if($column['country']=='' OR ( $column['zipcode']=='' AND $column['city']=='' ) )
			return false;

		return $column;		
	}
}