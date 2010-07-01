<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(dirname(__FILE__) . DS . 'defines.php');

class Proximity extends XiusBase
{
	var $encoder;

	function __construct()
	{		
		parent::__construct(__CLASS__);
	}
	
	public function getPluginParamsFromXml($key)
	{
		$paramsxmlpath	= dirname(__FILE__) . DS . 'params' . DS . $key.'.xml';
		$ini			= dirname(__FILE__) . DS . 'params' . DS . $key.'.ini';
		$data			= JFile::read($ini);
	
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,JText::_("INVALID XML PARAMETER FILE"));
			return false;
		}
		return true;
	}
	
	function getTableMapping()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		return $this->encoder->getTableMapping();
	}
	
	function isAllRequirementSatisfy()
	{
		if(isset($this->key) && !empty($this->key)){			
			require_once(dirname(__FILE__) . DS . 'encoders' . DS . 'encoder.php' );
			$this->encoder = XiusProximityEncoder::getProximityEncoder($this->key, $this->pluginParams);
			if($this->encoder)
				return true;
			
			return false;
		}

		return true;
	}
			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$pluginsInfo['information'] = JText::_('BY INFORMATION');
		//$pluginsInfo['database']	= JText::_('DATABASE');
		$pluginsInfo['google'] 		= JText::_('BY GOOGLE API');
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
		$plgName['information'] = JText::_('BY INFORMATION');
		//$plgName['database'] 	= JText::_('DATABASE');
		$plgName['google'] 		= JText::_('BY GOOGLE API');
		return $plgName[$this->key];
	}
	
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		$values	=	$this->validateValues($value);
		if(!$values)
			return false;
				
		$db = JFactory::getDBO();
		$columns = $this->getTableMapping();

		if(!$columns || !is_array($columns) || !$value)
			return false;		
			
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
			
		$query->select(" ROUND(( ".PROXIMITY_QUERY_CONSTANT." * acos( cos($latitude) * cos(radians({$db->nameQuote($columns[0]->cacheColumnName )}) )"
							." * cos( radians({$db->nameQuote($columns[1]->cacheColumnName )}) - ($longitude)) "
							." + sin( $latitude ) * sin( radians({$db->nameQuote($columns[0]->cacheColumnName )}) ) ) ) * $multiplier ,3)  "
							." AS xius_proximity_distance");
		

			$conditions =  " xius_proximity_distance < $distance ";
			$query->having($conditions,$join);
			// XITODO : Sorting according to distance
			//$query->order(" xius_proximity_distance ");				
		return true;
				
	}
	
	function formatPostForGeneratingInfo($postData)
	{
		if(isset($postData['rawdata'])){
			$this->key = $postData['rawdata'];
			$this->getPluginParamsFromXml($this->key);
		}
	}
	

	function _getArrangedValue($value)
	{
		if($value[0] == 'googlemap'){
			$values['address']  	= $value[1];
			$values['latitude']  	= $value[2];
			$values['longitude'] 	= $value[3];
			$values['distance'] 	= $value[4];
			$values['dis_unit'] 	= $value[5];
			return $values;
		}
		//XITODO : check value od value[0]
		if(empty($value[1]))
			return false;
			
		static $latitude  = null;
		static $longitude = null;
		if(!$latitude || !$longitude){		
			require_once ( XIUS_PATH_LIBRARY .DS. 'plugins' .DS. 'proximity' .DS.'googleapihelper.php');
			$geocodes  = ProximityGoogleapiHelper::_getGeocodes($value[1]);
			$latitude  = $geocodes['latitude'];
			$longitude = $geocodes['longitude'];
		}
		
		$values['address']  	= $value[1];
		$values['latitude']  	= $latitude;
		$values['longitude'] 	= $longitude;
		$values['distance'] 	= $value[4];
		$values['dis_unit'] 	= $value[5];
			
		return $values;
	}
	
	function bind($from, $ignore=array('debugMode','pluginType'))
	{
		$fromArray = (is_object($from) || is_array($from)) ? true : false;
		
		if (!$fromArray) {
			$this->setError( get_class( $this ).'::bind failed. Invalid from argument' );
			return false;
		}

		if(is_object( $from )) {
			//convert to array
			//$from = $from->toArray();
			$from = (array) ($from);
		}
		
		if (!is_array( $ignore )) {
			$ignore = explode( ' ', $ignore );
		}
		
		$this->getPluginParamsFromXml($from['key']);
		parent::bind($from, $ignore);
	}
	
	public function getDependentInfo()
	{
		$infoId = array();
		if($this->key === 'database' || $this->key === 'google'){
			$infoId['city'] = $this->pluginParams->get('xius_proximity_city',-1);
			$infoId['country'] = $this->pluginParams->get('xius_proximity_country',-1);
			$infoId['state'] = $this->pluginParams->get('xius_proximity_state',-1);
			$infoId['zipcode'] = $this->pluginParams->get('xius_proximity_zipcode',-1);
			return $infoId;			
		}
		
		if($this->key === 'information'){
			$infoId['latitude'] = $this->pluginParams->get('xius_proximity_latitude',-1);
			$infoId['longitude'] = $this->pluginParams->get('xius_proximity_longitude',-1);
			return $infoId;
		}
		
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
		if(!is_array($value) || count($value) < 6)
			return false;

		$value = $this->_getArrangedValue($value);
		if(!$value)
			return false;
			
		if( !is_numeric($value['latitude']) || !is_numeric($value['longitude']) 
				|| !is_numeric($value['distance']) || is_numeric($value['dis_unit']) )
			return false;
			
		return $value;
	}
	
	public function _getFormatAppliedData($value)
	{
		$value = $this->_getArrangedValue($value);
		
		return $value['distance'].' '.$value['dis_unit'].' '.JText::_('RANGESEARCH FROM').'<br/>'.$value['address'];	
	}	
}
