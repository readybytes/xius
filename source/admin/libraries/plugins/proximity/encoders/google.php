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
		$table = '#__xius_proximity_geocode';
		$originalLatColumn  = 'latitude';
		$originalLongColumn = 'longitude';
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_google";
		$object->originColumnName	= $originalLatColumn;
		$object->cacheColumnName	= "proximity_google_latitude_$count";
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName		= JText::_('LATITUDE');
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_google";
		$object->originColumnName	= $originalLongColumn;
		$object->cacheColumnName	= 'proximity_google_longitude_'.$count;
		$object->cacheSqlSpec		= ' Float (10,6) NOT NULL DEFAULT 0 ';
		$object->cacheLabelName 	= JText::_('LONGITUDE');
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$object	= new stdClass();
		$object->tableName			= $table;
		$object->tableAliasName 	= "xius_proximity_google";
		$object->originColumnName	= 'address';
		$object->cacheColumnName	= 'proximity_google_address_'.$count;
		$object->cacheSqlSpec		= ' varchar(250) NOT NULL ';
		$object->cacheLabelName 	= JText::_('ADDRESS');
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		return $tableInfo;
	}
	
	/*public function getDatabaseCloumnName()
	{
		$column['city'] 	= 'city';
		$column['zipcode']  = 'zipcode';
		$column['country'] 	= 'country';		
		$column['state']	= 'state';
		
		return $column;		
	}*/
	
	public function getUserData(XiusQuery &$query, $ptm)
	{
		$instanceId[]	= $this->params->get('xius_proximity_city');
		$instanceId[]	= $this->params->get('xius_proximity_state');
		$instanceId[]	= $this->params->get('xius_proximity_country');
		$instanceId[]	= $this->params->get('xius_proximity_zipcode');
		$tableMapping=array();
		foreach($instanceId as $value){
			$instance		= XiusFactory::getPluginInstanceFromId($value);
			if(!$instance)
				continue;
				
			$mapping = $instance->getTableMapping();
			array_push($tableMapping, $mapping[0]);
		}

		// select latitude column
		$query->select(" {$ptm[0]->tableAliasName}.`{$ptm[0]->originColumnName}` "
						." as {$ptm[0]->cacheColumnName}"
					   );
		// select longitude column
		$query->select(" {$ptm[1]->tableAliasName}.`{$ptm[1]->originColumnName}` "
						." as {$ptm[1]->cacheColumnName}"
					   );

		/*if(empty($tableMapping))	
			return false;*/
			
		$address = array();
		foreach($tableMapping as $tm)
				$address[] =" {$tm->tableAliasName}.`{$tm->originColumnName}` ";
				
		$address = implode(',',$address);
		$query->select(" CONCAT_WS(',' , $address ) "
						." as {$ptm[2]->cacheColumnName} "
					   );
		
		$query->leftJoin(" `{$ptm[0]->tableName}` as {$ptm[0]->tableAliasName} ON "
					." (  CONCAT_WS(',' , $address ) = {$ptm[0]->tableAliasName}.`{$ptm[2]->originColumnName}` )" 
					);		
		
	}
	
}