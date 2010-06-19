<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.file' );

class XiusProximityEncoder 
{			
	static public function getProximityEncoder($encoderName,$params)
	{
		$encoderClassName 	= 'Proximity'.$encoderName.'Encoder';
		$encoderName 		= strtolower($encoderName);
		$encoderPath		=  dirname(__FILE__) . DS . $encoderName.'.php';
		
		if(!JFile::exists($encoderPath))
		{
			JError::raiseError(500,JText::_("INVALID ENCODER FILE"));
			return false;
		}

		require_once $encoderPath;
		// XITODO : validate , class exists or not	
		$instances = new $encoderClassName($params);
				
		return $instances;	
	}	
	
	function getTableMapping()
	{
		return array();
	}
	
	public function getUserData(XiusQuery &$query, $proximityTM)
	{
		$columnName = $this->getDatabaseCloumnName();
		if(empty($columnName) || !is_array($columnName))
			return false;

		$instanceId['city']		= $this->params->get('xius_proximity_city');
		$instanceId['zipcode']	= $this->params->get('xius_proximity_zipcode');
		$instanceId['state']	= $this->params->get('xius_proximity_state');
		$instanceId['country']	= $this->params->get('xius_proximity_country');
				
		if(!$instanceId['city'] && !$instanceId['zipcode'])
			return false;
		
		foreach($instanceId as $key => $value){
			$instance		= XiusFactory::getPluginInstanceFromId($value);
			if(!$instance)
				continue;
				
			$tableMapping[$key] = $instance->getTableMapping();
		}
		
		
				
		foreach($proximityTM as $ptm){
			
			$query->select(" {$ptm->tableAliasName}.`{$ptm->originColumnName}` "
							." as {$ptm->cacheColumnName}"
						   );
			$join="";
			// 	column name od proximity database and instanse for tha same filed , both must exists
			if(array_key_exists('city',$tableMapping) && $tableMapping['city'] && $columnName['city']!='')
				$join = " {$ptm->tableAliasName}.`{$columnName['city']}`  = {$tableMapping['city'][0]->tableAliasName}.`{$tableMapping['city'][0]->originColumnName}` ";

			if($join != '' && array_key_exists('zipcode',$tableMapping) && $tableMapping['zipcode'] && $columnName['zipcode']!='')
				$join .=" OR ";

			if(array_key_exists('zipcode',$tableMapping) && $tableMapping['zipcode'] && $columnName['zipcode']!='')
				$join .= " {$ptm->tableAliasName}.`{$columnName['zipcode']}` = {$tableMapping['zipcode'][0]->tableAliasName}.`{$tableMapping['zipcode'][0]->originColumnName}` ";
			
			if($join =="")
				return false;				

			$query->leftJoin(" `{$ptm->tableName}` as {$ptm->tableAliasName} ON "
						." ( ( $join ) "
						." AND {$ptm->tableAliasName}.`{$columnName['country']}` = {$tableMapping['country'][0]->tableAliasName}.`{$tableMapping['country'][0]->originColumnName}` "
						." ) "
						);		
		}
	}
	
	public function getDatabaseCloumnName()
	{
		return array();
	}
}
