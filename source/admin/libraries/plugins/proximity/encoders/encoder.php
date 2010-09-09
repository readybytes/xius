<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
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
			JError::raiseError(500,XiusText::_("INVALID ENCODER FILE"));
			return false;
		}

		require_once $encoderPath;
		//  validate , class exists or not		
		if(class_exists($encoderClassName,true)){
			$instances = new $encoderClassName($params);
			return $instances;
		}

		JError::raiseError(500,XiusText::_("ENCODER CLASS MISSING")." :$encoderClassName");
		return false;
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
			if(array_key_exists('zipcode',$tableMapping) && $tableMapping['zipcode'] && $columnName['zipcode']!='')
				$join = " AND {$ptm->tableAliasName}.`{$columnName['zipcode']}` = {$tableMapping['zipcode'][0]->tableAliasName}.`{$tableMapping['zipcode'][0]->originColumnName}` ";
			
			$query->leftJoin(" `{$ptm->tableName}` as {$ptm->tableAliasName} ON "
						." ( {$ptm->tableAliasName}.`{$columnName['city']}` = {$tableMapping['city'][0]->tableAliasName}.`{$tableMapping['city'][0]->originColumnName}` " 
						." AND {$ptm->tableAliasName}.`{$columnName['country']}` = {$tableMapping['country'][0]->tableAliasName}.`{$tableMapping['country'][0]->originColumnName}` "
						." AND {$ptm->tableAliasName}.`{$columnName['state']}` = {$tableMapping['state'][0]->tableAliasName}.`{$tableMapping['state'][0]->originColumnName}` "
						." $join ) "
						);		
		}
		return true;
	}
	
	public function getDatabaseCloumnName()
	{
		return array();
	}
}
