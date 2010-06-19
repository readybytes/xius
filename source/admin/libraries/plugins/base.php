<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

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
	protected $debugMode	= 	false;
	
	function __construct($className)
	{		
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->params = new JParameter($data,$paramsxmlpath);
			
		$this->pluginType 	= $className;
		
		//if already defined by child class do not create it.
		if(!$this->pluginParams)
			$this->pluginParams	= new JParameter('','');
			
		$this->debugMode = XiusHelpersUtils::getDebugMode();
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
			JError::raiseError(400,JText::_("INVALID PLUGIN FILE"));
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
			$info = XiusLibrariesInfo::getInfo($filter);
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
		return true;
	}
	
	/*public function getisdoAble($what,$default=false)
	{
		$isAble = $this->getValueFromParams($this->params,$what,$default);
		return $isAble;
	}*/
	
	
	public function isSearchable()
	{
		$isSearchable = XiusHelpersUtils::getValueFromXiusParams($this->params,'isSearchable',false);
		return $isSearchable;
	}
	
	public function isVisible()
	{
		$isVisible = XiusHelpersUtils::getValueFromXiusParams($this->params,'isVisible',false);
		return $isVisible;
	}
	
	
	public function isSortable()
	{
		$isSortable = XiusHelpersUtils::getValueFromXiusParams($this->params,'isSortable',false);
		return $isSortable;
	}
	

	public function isExportable()
	{
		$isExportable = XiusHelpersUtils::getValueFromXiusParams($this->params,'isExportable',false);
		return $isExportable;
	}

	final public function getTooltip()
	{
		return XiusHelpersUtils::getValueFromXiusParams($this->params,'tooltip',false);
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
			$html .= "<option value='$k'>".JText::_($v)."</option>"; 
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
		
		$plguinParamsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
		return $plguinParamsHtml;
	}
	
	
	final public function getParamsHtml()
	{
		$paramsHtml = $this->params->render('params');
		
		if($paramsHtml)
			return $paramsHtml;
		
		$paramsHtml = "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		
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
	

	
	/*XITODO : function will decide which user can search
	 *  sort etc from which info 
	 *  will be helpful for PROFILETYPE layouts etc at later
	 *  break in 2 function : accessible according to core
	 *  2 : according to plugin 
	 */
	public function isAccessible($userid,$what='search')
	{
		return true;
	}

	
	/*get table mapping data for given plugin*/
	function getTableMapping()
	{
		$tableInfo					= array();
		return $tableInfo;
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
	
	
	function appendCreateQuery(XiusCreateTable &$createQuery)
	{
		$db = JFactory::getDBO();
		$columns = $this->getTableMapping();
		
		if(empty($columns))
			return false;

		$columnDeatils = array();
		// XITODO : is set $c->createCacheColumn
		foreach($columns as $c){
			if($c->createCacheColumn == false)
				continue;
			
			$columnDeatils[]  = " `{$c->cacheColumnName}` {$c->cacheSqlSpec} ";
		}		
		$createQuery->appendColumns($columnDeatils);
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
			$conditions =  $db->nameQuote($c->cacheColumnName).$operator."'".$this->formatValue($value)."'";
			$query->where($conditions,$join);
		}		
		return true;	
	}
	
	
	function collectParamsFromPost(&$key,&$pluginParams,$postdata)
	{
		if(isset($postdata['pluginParams']) && $postdata['pluginParams']){
			$registry	=& JRegistry::getInstance( 'xius' );
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
		$cache = XiusFactory::getCacheObject();
		$tname = $cache->getTableName();
		$utname = 'userid';
		$columns = $this->getTableMapping();

		if(empty($columns))
			return false;

		$db =& JFactory::getDBO();
		
		/**
		 * XITODO : Add all cache columns if one instance is 
		 * 			displaying multiple information
		 * */
		foreach($columns as $c){
			if(!empty($c->cacheColumnName))
				$cname = $db->nameQuote($c->cacheColumnName);
		}
		
		$query = ' SELECT '.$cname
				.' FROM '  .$db->nameQuote($tname)
				.' WHERE ' .$db->nameQuote($utname).'='.$db->Quote($userid);
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
			$this->params = new JParameter($data,$paramsxmlpath);
		
		$this->cleanPluginObject();
		
		$this->key		 = '';
		$this->id		 = 0;
	}
	
	public function cleanPluginObject()
	{
		//if already defined by child class do not create it.
		if(!$this->pluginParams)
			$this->pluginParams	= new JParameter('','');	
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
	public function getDisplayData($userprofile,$data, $info)
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
