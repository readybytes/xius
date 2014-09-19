<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

abstract class XiusBase extends JObject
{
	protected $id			=	0 ;
	protected $labelName	=	'';
	protected $params;
	
	/*plugin will provide entry for this */
	/*key = unique name for understanding of plugin */
	protected $key;
	protected $pluginParams;
	
	/*base class will manage it ,not the tension of pluign  */
	protected $pluginType;
	protected $oredring		=	0;
	protected $published	=	1;
	
	function __construct($className)
	{		
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->params = new XiusParameter($data,$paramsxmlpath);
			
		$this->pluginType 	= $className;
		
		//if already defined by child class do not create it.
		if(!$this->pluginParams)
			$this->pluginParams	= new XiusParameter('','');
			
		$this->key		 = '';
		$this->id		 = 0;
	}
	
	function getController($className)
	{
		$pluginName = strtolower($this->pluginType);
		$pluginPath	= dirname(__FILE__). DS . $pluginName . DS . 'controller.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($pluginPath))
		{
			JError::raiseError(400,XiusText::_("INVALID_CONTROLLER_FILE"));
			return false;
		}
		
		require_once $pluginPath;
		return new $className();
	}
	
	function setData($what,$value)
	{
		if(in_array($what,$this->getProperties()))
			$this->$what = $value;
	}
	

	function getData($what)
	{
		if(in_array($what,$this->getProperties()))
			return $this->$what;
			
		return false;
	}
	
	/*if it returns false means we can't access it's object
	 * it will not behave as expected
	 */
	function isAllRequirementSatisfy()
	{
		return true;
	}
	
	
	function load($id)
	{
		if($id) {
			$filter = array();
			$filter['id'] = $id;
			$info = XiusLibInfo::getInfo($filter);
			if($info)
				$this->bind($info[0]);
		}
	}
	
	/* function will return array of all value */
	function toArray()
	{
		return $this->getProperties();
		/*$array =  (array) ($this);
		return $array;*/
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
		
		
		foreach ($this->getProperties() as $k => $v) {
			// internal attributes of an object are ignored
			if (!in_array( $k, $ignore )) {
				if (isset( $from[$k] )) {
					if($k === 'pluginParams' || $k === 'params')
						$this->$k->bind($from[$k]);
					else
						$this->$k = $from[$k];
				}
			}
		}
		$this->checkConfiguration('',true);
		return true;
	}
	
	/*public function getisdoAble($what,$default=false)
	{
		$isAble = $this->getValueFromParams($this->params,$what,$default);
		return $isAble;
	}*/
	
	public function isCoreAccessible($user)
	{	
		if(XIUS_JOOMLA_15){
			$userGroup = $user->usertype;
		}
		else{
			$userGroup = JUserHelper::getUserGroups($user->id); //if J2.5 then usertype is blank so we use group i.e an array
		}
		
		if(!$userGroup)
			$userGroup = 'Guest Only';
		
		if(	true == XiusHelperUtils::isAdmin($user->id))
			return true;
			
		$accessibleGroup = unserialize($this->params->get('isAccessible'));
		
		// XITODO : if any user group is not selected then what, is it should be public
		if(!is_array($accessibleGroup))
			return true;
			
		if(in_array('All', $accessibleGroup))
			return true; 

		//if usertype is value rather than its groupId then convert it to the corresponding groupId
		if(!is_numeric($userGroup) && !is_array($userGroup)){
			$GroupName = XiusHelperUsers::getJoomlaGroups();
			foreach ($GroupName as $key=>$value){
				if($value->{XIUS_JOOMLA_GROUP_VALUE} == $userGroup){
						$userGroup = $value->id;
						break;
				}
			}
		}
		
		// create array for making it for doing common prrocessing in all versions of joomla
		if(!is_array($userGroup)){
			$userGroup = array($userGroup);
		}
		
		foreach ($userGroup as $usergrp){
			if(in_array($usergrp, $accessibleGroup))
				return true;
		}
		
		return false;
	}
	
	public function isInfoAccessible()
	{
		return true;
	}
	
	// XITODO : support for Profile type in accessibility
	public function isAccessible($reset=false)
	{
		static $isAccessible = null;
		if($reset){
			$isAccessible = null;
			return;
		}
		if($isAccessible!=null)
			return $isAccessible;
			 
		$user 		= JFactory::getUser();		
		$coreAccessible = $this->isCoreAccessible($user);
		$infoAccessible = $this->isInfoAccessible();
		if($coreAccessible && $infoAccessible)
			$isAccessible = true;		
		else 
			$isAccessible = false;
		
		return $isAccessible;
	}

	// XITODO : function clean up
	public function checkConfiguration($what,$reset=false)
	{		
		static $config = array();
		if($reset){
			$this->isAccessible(true);
			$config = array();
			return;
		}
		
		if(array_key_exists($what,$config) &&  isset($config[$what]))
			return $config[$what];
			
		$config[$what] = XiusHelperUtils::getValueFromXiusParams($this->params,$what,false);
		if($config[$what]==true)
			$config[$what] = $this->isAccessible();
		
		return $config[$what];
	}
	
	public function isSearchable($reset=false)
	{
		return $this->checkConfiguration(__FUNCTION__,$reset);
		
	}
	
	public function isVisible($reset=false)
	{
		return $this->checkConfiguration(__FUNCTION__,$reset);
	}
	
	
	public function isSortable($reset=false)
	{
		return $this->checkConfiguration(__FUNCTION__,$reset);		
	}
	

	public function isExportable()
	{
		$isExportable = XiusHelperUtils::getValueFromXiusParams($this->params,'isExportable',false);
		return $isExportable;
	}

	final public function getTooltip()
	{
		return XiusHelperUtils::getValueFromXiusParams($this->params,'tooltip',false);
	}
	

	public function isKeywordCompatible()
	{
		return true;
	}
	
	/*override function if child class is displaying 
	 * fields html with not in select box and any other method
	 */
	function formatPostForGeneratingInfo($postData)
	{
		if(isset($postData['rawdata'])){
			$this->key = $postData['rawdata'];
		}
	}
	
	
	/*function will display listing of plugins */
	/*function renderRawData()
	{
		$pluginsInfo = $this->getAvailableInfo();
		if(!$pluginsInfo)
			return false;

		$html = "<select id = 'rawdata' name = 'rawdata' >";
		foreach($pluginsInfo as $k => $v){
			$html .= "<option value='$k'>".XiusText::_($v)."</option>"; 
		}
		
		$html .= "</select>";
		
		return $html;
	}*/
	
	
	public function renderRawDataHtml()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$view = $this->getViewName();
		if(false === $view)
			return $this->renderRawData();
		
		return $view->rawDataHtml($this);
	}
	
	
	/*backend usage fn
	 * fn will render plugin and core param html
	 */
	public function getHtml(&$paramsHtml,&$plguinParamsHtml)
	{
		//Imp : Function will always call core field html
		$paramsHtml = $this->getParamsHtml();
		$plguinParamsHtml = $this->getPluginParamsHtml();
	}
	
	
	public function getPluginParamsHtml()
	{		
		$plguinParamsHtml = $this->pluginParams->render('pluginParams');
		
		if($plguinParamsHtml)
			return $plguinParamsHtml;
		
		$plguinParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".XiusText::_('THERE_ARE_NO_PARAMETERS_FOR_THIS_ITEM')."</div>";
		
		return $plguinParamsHtml;
	}
	
	public function getPluginParamsFromXml($key)
	{
		return true;
	}
	
	final public function getParamsHtml()
	{
		$paramsHtml = $this->params->render('params');
		
		if($paramsHtml)
			return $paramsHtml;
		
		$paramsHtml = "<div style=\"text-align: center; padding: 5px; \">".XiusText::_('THERE_ARE_NO_PARAMETERS_FOR_THIS_ITEM')."</div>";
		
		return $paramsHtml;
	}
	
	
	
	protected function generateSearchHtml($value = '')
	{
		$infoIdStartHtml = '<input type = "hidden" name="xiusinfo_'.$this->id.'1" id="xiusinfo_'.$this->id.'1" value="'.$this->id.'"/>';
		$inputHtml = '<input class="inputbox" type="text" name="'.$this->pluginType.'_'.$this->id.'" id="'.$this->pluginType.'_'.$this->id.'"  value = "'.$value.'"/>';
		$infoIdEndHtml = '<input type = "hidden" name="xiusinfo_'.$this->id.'2" id="xiusinfo_'.$this->id.'2" value="'.$this->id.'"/>';
		$htmlwithInfoId = $infoIdStartHtml . $inputHtml . $infoIdEndHtml;
		
		return $htmlwithInfoId;
	}
	
	/*this function is defined for front-end
	 * return label + input box html
	 */
	public function renderSearchableHtml($value = '')
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$view = $this->getViewName();
		if(false === $view)
			return $this->generateSearchHtml($value);

		$html = $view->searchHtml($this,$value);
		if(!empty($html)){
			$infoIdStartHtml = '<input type = "hidden" name="xiusinfo_'.$this->id.'1" id="xiusinfo_'.$this->id.'1" value="'.$this->id.'"/>';
			$infoIdEndHtml = '<input type = "hidden" name="xiusinfo_'.$this->id.'2" id="xiusinfo_'.$this->id.'2" value="'.$this->id.'"/>';
			$htmlwithInfoId = $infoIdStartHtml . $html . $infoIdEndHtml;
			return $htmlwithInfoId;
		}

		return false;
	}

	
	
	public function renderSortableHtml()
	{
		$html = array();
		$html['key'] = $this->id;
		$html['value'] = $this->labelName;
		return $html;
	}
	
	
	
	protected function getViewName()
	{
		/*We expect here that every plugin should have view 
		 * for display inteface .We will include view file
		 * and directly call function for displaying html
		 */
		$lowercase = strtolower($this->pluginType);
		
		$basePath = dirname(__file__).DS.$lowercase;
		$viewPath = $basePath.DS.'views'.DS.'view.html.php';
		
		if(!JFile::exists($viewPath))
			return false;
			
		require_once $viewPath;
		
		/*view class name = plugin class name with View*/
		$viewClass = $this->pluginType.'View';
		$view = new $viewClass();
		return $view;
	}
		
	/*get table mapping data for given plugin*/
	function getTableMapping()
	{
		$tableInfo					= array();
		return $tableInfo;
	}
		
	public function getSortableTableMapping()
	{
		return $this->getTableMapping();
	}
	
	/*fn return exact parameter details that will store
	 * in that field
	 */ 
		
	function getCacheSqlSpec($key)
	{
		return 'varchar(250) NOT NULL'; 
	}
	
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
	}
	
	
	/*function update query	 */
	public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		/*
		 * it's handling query only for single value
		 * if column needs multiple comparision then they should handle
		 */
		
		if($this->validateValues($value) == false)
			return false;
			
		$db = JFactory::getDBO();
		
		if(is_array($value))
			return false;
			
		$columns = $this->getTableMapping();
		if(empty($columns))
			return false;

		foreach($columns as $c){
			$conditions =  $db->quoteName($c->cacheColumnName).$operator."'".$this->formatValue($value)."'";
			$query->where($conditions,$join);
		}		
		return true;	
	}
	
	
	function collectParamsFromPost(&$key,&$pluginParams,$postdata)
	{
		if(isset($postdata['pluginParams']) && $postdata['pluginParams']){
			$registry	= new JRegistry;
			$registry->loadArray($postdata['pluginParams'],'xius_pluginParams');
			$pluginParams =  $registry->toString('INI' , 'xius_pluginParams' );
		}
		$key = $postdata['key'];
		return true;
	}
	
	
	/*function will format data if any plugin required , they will override it 
	 * it will help to search data in table according to exist
	 * means how data can be find in table
	 * Eq :- profiletype ( format value = $ptypeid ) 
	 */
	protected function formatValue($value)
	{
		return $value;
	}
	
    /*function will format column  
	 * means how the column is formated for searching 
	 */
	function formatColumn($column , $db)
	{
		return $db->quoteName($column->cacheColumnName);
	}
	
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		return false;
	}
	
	public function getMe()
	{
		$name =  get_class($this);
		return $name;
	}
	
	function removeExistingInfo(&$info,$availableInfo)
	{
		if(empty($info) || empty($availableInfo))
			return true;

		foreach($availableInfo as $ai){
			if(array_key_exists($ai->key,$info)
					&& $this->pluginType == $ai->pluginType)
				unset($info[$ai->key]);
		}
		
		return true;
	}
	
	
	function getMiniProfileDisplay($userid,$cname)
	{
		$cache = XiusFactory::getInstance('cache');
		$tname = $cache->getTableName();
		$utname = 'userid';
		$columns = $this->getTableMapping();

		if(empty($columns))
			return false;

		$db = JFactory::getDBO();
		
		/**
		 * XITODO : Add all cache columns if one instance is 
		 * 			displaying multiple information
		 * 		Not being used now
		 * */
		foreach($columns as $c){
			if(!empty($c->cacheColumnName))
				$cname = $db->quoteName($c->cacheColumnName);
		}
		
		$query = ' SELECT '.$cname
				.' FROM '  .$db->quoteName($tname)
				.' WHERE ' .$db->quoteName($utname).'='.$db->Quote($userid);
		$db->setQuery($query);
		$result = $db->loadResult();
		
		$value = $this->_getFormatData($result);
		return $value; 
	}
	
	
	/*Available for converting raw data into format data*/
	public function _getFormatData($value)
	{
		if(is_array($value)) {
			$formatvalue = implode(',',$value);
			return $formatvalue;
		}
		
		return $value; 
	}
	
	// format the value for applied info
	public function _getFormatAppliedData($value)
	{
		return $this->_getFormatData($value);
	}
	
	/*every constructed object should be clean 
	 * before giving another to access old data
	 */
	public function cleanObject()
	{
		/*XITODO : never initialize params again
		 * only clean values
		 */ 
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->params = new XiusParameter($data,$paramsxmlpath);
		
		$this->cleanPluginObject();
		
		$this->key		 = '';
		$this->id		 = 0;
	}
	
	public function cleanPluginObject()
	{
		//if already defined by child class do not create it.
		if(!$this->pluginParams)
			$this->pluginParams	= new XiusParameter('','');	
	}
	
	public function validateValues($value)
	{
		return true;		
	}
	
	/*
	 * to get the dependent information of current information
	 */
	public function getDependentInfo()
	{
		return array();
	}
	
	/*
	 * To get the data, which will be displayed on users profile 
	 */
	public function getDisplayData(&$userprofile,$data, $info)
	{			
		foreach($data['users'] as $u){
			$lname=array();
			$cname=array();
		    $columns = $this->getTableMapping();
			if(empty($columns) || !$columns)
				break;

			// get the cache column name and label name
			foreach($columns as $c){
				if(!empty($c->cacheColumnName) && !empty($c->cacheLabelName)){
					$cname[] = $c->cacheColumnName;
					$lname[] = $c->cacheLabelName;
				}
			}

			// get the temporary column name and label name which are not in cache table
			$tempColumnName = $this->getTempColumnName();
			foreach($tempColumnName as $tlabel => $tcolumn ){
				if(!empty($tcolumn) && !empty($tlabel) && isset($u->$tcolumn)){
					$cname[] = $tcolumn;
					$lname[] = $tlabel;
				}
			}
				
			$userprofile[$u->userid][$info->id]['label'] = $lname;
			
			foreach($cname as $c){
				//if(isset($u->$c))
        			$userprofile[$u->userid][$info->id]['value'][] = $this->_getFormatData($u->$c);
        		//else
        		//	$userprofile[$u->userid][$info->id]['value'][] = $this->getMiniProfileDisplay($u->userid, $c);
			}
        }
	}
	
	public function getTempColumnName()
	{
		return array();
	}
	
	
}
