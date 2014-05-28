<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

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
			$this->pluginParams = new XiusParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,XiusText::_("INVALID_XML_PARAMETER_FILE"));
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
	
	function getSortableTableMapping()
	{
		if($this->isSortable()==false)
			return false;
			
		$object	= new stdClass();
		$object->cacheColumnName = 'xius_proximity_distance';
		$tableInfo[]=$object;
		return $tableInfo;
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
			
		$pluginsInfo['information'] = XiusText::_('BY_INFORMATION');
		//$pluginsInfo['database']	= XiusText::_('DATABASE');
		$pluginsInfo['google'] 		= XiusText::_('BY_GOOGLE_API');
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
		$plgName['information'] = XiusText::_('BY_INFORMATION');
		//$plgName['database'] 	= XiusText::_('DATABASE');
		$plgName['google'] 		= XiusText::_('BY_GOOGLE_API');
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
		// XITODO :: Temporary fix for having clause need to fix it
		$sql="	ROUND(( ".PROXIMITY_QUERY_CONSTANT." * acos( cos($latitude) * cos(radians({$db->quoteName($columns[0]->cacheColumnName )}) )"
							." * cos( radians({$db->quoteName($columns[1]->cacheColumnName )}) - ($longitude)) "
							." + sin( $latitude ) * sin( radians({$db->quoteName($columns[0]->cacheColumnName )}) ) ) ) * $multiplier ,3)  ";
			
		$query->select(" {$sql} AS xius_proximity_distance");		
		$conditions =  " $sql <= $distance ";
		$query->where($conditions,$join);
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
			if($value[0] == 'googlemap' || $value[0] == 'mylocation'){
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
			require_once ( XIUS_PLUGINS_PATH.DS. 'proximity' .DS.'googleapihelper.php');
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
		return true;
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
	
	public function isSortable($reset = false)
	{
		$conditions = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		if(!is_array($conditions) || empty($conditions))
			return false;

		foreach($conditions as $cond ){
			if($cond['infoid'] == $this->id && $this->validateValues($cond['value']) != false)
				return true;				
		}		
		return false;
	}
	
	public function getTempColumnName()
	{
		$tempColumn[XiusText::_('DISTANCE')] = "xius_proximity_distance";
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
		$apiKey = '';
		$key  = $this->pluginParams->get('xius_gmap_key');
		if(!empty($key)){
			$apiKey = "&key={$key}";
		}
		
		$value 		= $this->validateValues($value);
		if(!$value)
			return false;
			
		$linkMap 	= "http://maps.google.com/maps/api/staticmap?center=".$value['latitude'].",".$value['longitude']."&zoom=7&size=".PROXIMITY_APPLIED_IFRAME_WIDTH."x".PROXIMITY_APPLIED_IFRAME_HEIGHT
		 			."&maptype=roadmap&markers=size:large|color:Red|label:S|".$value['latitude'].",".$value['longitude'].$apiKey."&sensor=false"
					."";
		$buttonMap 	= XiusFactory::getModalButtonObject('xius_show_location_map', XiusText::_('SHOW_LOCATION') ,$linkMap,PROXIMITY_APPLIED_IFRAME_WIDTH,PROXIMITY_APPLIED_IFRAME_HEIGHT,'image');
        $fieldHtml     = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'.$buttonMap->text.'</a>';
		return array($fieldHtml);	
	}	
	
	public function isKeywordCompatible()
	{
		return false;
	}
}
