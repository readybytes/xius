<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

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
		$object->cacheColumnName	= "proximity_latitude_$count";
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName		= JText::_('LATITUDE');
		$object->createCacheColumn	=	true;
		$tableInfo[]=$object;
		
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_longitude";
		$object->originColumnName	= $originalLongColumn;
		$object->cacheColumnName	= 'proximity_longitude_'.$count;
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName 	= JText::_('LONGITUDE');
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