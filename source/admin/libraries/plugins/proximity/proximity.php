<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(dirname(__FILE__) . DS . 'defines.php');

class Proximity extends XiusBase
{
	var $encoder;

	function __construct()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		
		parent::__construct(__CLASS__);
	}
	
	function getTableMapping()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		return $this->encoder->getTableMapping();
	}
	
	function isAllRequirementSatisfy()
	{
		require_once(dirname(__FILE__) . DS . 'encoders' . DS . 'encoder.php' );
		$this->encoder = XiusProximityEncoder::getProximityEncoder($this->pluginParams->get('xius_proximity_encoding','Information'), $this->pluginParams);
		if($this->encoder)
			return true;

		return false;
	}
			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$pluginsInfo[0] = JText::_('GEOCODING');
		return $pluginsInfo;
	}
	
	
	function getUserData(XiusQuery &$query)
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$myTableMapping = $this->getTableMapping();
		if(empty($myTableMapping))
			return false;
			
		return $this->encoder->getUserData($query,$myTableMapping);			
	}
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$plgName[0] = JText::_('GEOCODING');
		return $plgName[$this->key];
	}
	
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		if($this->validateValues($value) == false)
			return false;
				
		$db = JFactory::getDBO();
		$columns = $this->getTableMapping();

		if(!$columns || !is_array($columns) || !$value)
			return false;
			
		$values 	= $this->_getArrangedValue($value); 
		$latitude	= deg2rad($values['latitude']);
		$longitude	= deg2rad($values['longitude']);
		$multiplier = PROXIMITY_MILES_TO_MILES;
		// XITODO : need to clean up magic constants
		if( $values['dis_unit'] === 'kms' ){
			$multiplier = PROXIMITY_MILES_TO_KMS;
		}			 
		$distance	= $values['distance'];
		//apply search
		/*$multiplier = 1;
		if($value[3]=='kms')
			$multiplier = ;
		*/
			
		$query->select(" ROUND(( ".PROXIMITY_QUERY_CONSTANT." * acos ( cos($latitude) * cos(radians({$db->nameQuote($columns[0]->cacheColumnName )}) )"
							." * cos( radians({$db->nameQuote($columns[1]->cacheColumnName )}) - $longitude) "
							." + sin( $latitude ) * sin( radians({$db->nameQuote($columns[0]->cacheColumnName )}) ) ) ) * $multiplier ,3)  "
							." AS xius_proximity_distance");
		

			$conditions =  " xius_proximity_distance < $distance ";
			$query->having($conditions);
			// XITODO : Sorting according to distance
			//$query->order(" xius_proximity_distance ");				
		return true;
				
	}

	function _getArrangedValue($value)
	{
		if( $this->key == 0 )
		{
			$values['latitude']  	= $value[0];
			$values['longitude'] 	= $value[1];
			$values['distance'] 	= $value[2];
			$values['dis_unit'] 	= $value[3];
			return $values;
		}	
	}
	
	public function cleanPluginObject()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);		
	}
	
	public function getDependentInfo()
	{
		$infoId[] = $this->pluginParams->get('xius_proximity_city',-1);
		$infoId[] = $this->pluginParams->get('xius_proximity_country',-1);
		$infoId[] = $this->pluginParams->get('xius_proximity_state',-1);
		$infoId[] = $this->pluginParams->get('xius_proximity_zipcode',-1);
		return $infoId;
	}
	
	
	public function getTempColumnName()
	{
		$tempColumn[JText::_('DISTANCE')] = "xius_proximity_distance";
		return $tempColumn;
	}
	
	public function _getFormatData($value)
	{
		return $value;
	}
	
	function validateValues($value)
	{
		if(!is_array($value) || count($value)<4)
			return false;

		$value = $this->_getArrangedValue($value);
		if( !is_numeric($value['latitude']) || !is_numeric($value['longitude']) 
				|| !is_numeric($value['distance']) || is_numeric($value['dis_unit']) )
			return false;
			
		return true;
	}
}
