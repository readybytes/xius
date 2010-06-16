<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class ProximityGoogleEncoder extends XiusProximityEncoder
{
	var $params = '';
	
	function __construct($params)
	{
		$this->params = $params;
	}
	
	function getTableMapping()
	{
		$table = '#__xius_proximity';
		$originalLatColumn  = 'latitude';
		$originalLongColumn = 'longitude';
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_latitude";
		$object->originColumnName	= $originalLatColumn;
		$object->cacheColumnName	= "latitude_$count";
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName		= JText::_('LATITUDE');
		$tableInfo[]=$object;
		
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_longitude";
		$object->originColumnName	= $originalLongColumn;
		$object->cacheColumnName	= 'longitude_'.$count;
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName 	= JText::_('LONGITUDE');
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	public function getDatabaseCloumnName()
	{
		$column['city'] 	= 'city';
		$column['zipcode']  = 'zipcode';
		$column['country'] 	= 'country';		
		$column['state']	= 'state';
		
		return $column;		
	}
}