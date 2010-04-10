<?php

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
		//XITODO: add default.ini
		if(JFile::exists($paramsxmlpath))
			$this->params = new JParameter('',$paramsxmlpath);
			
		$this->pluginType 	= $className;
		
		//if already defined by child class do not create it.
		if(!$this->pluginParams)
			$this->pluginParams	= new JParameter('','');
			
		$this->debugMode = XiusFactory::getDebugMode();
		$this->key		 = '';
		$this->id		 = 0;
	}
	
	
	function setData($what,$value)
	{
		if(in_array($what,$this->getProperties()))
			$this->$what = $value;
	}
	
	/*public static function getInstance($pluginname,$id=0)
	{
		$path	= dirname(__FILE__). DS . $pluginname . DS . $pluginname.'.php';
		jimport( 'joomla.filesystem.file' );
		if(!JFile::exists($path))
		{
			JError::raiseError(400,JText::_("INVALID PLUGIN FILE"));
			return false;
		}

		require_once $path;
			
		//$instance will comtain all plugin object according to info
		//Every info will have different object
		static $instances = array();
		if(!isset($instances[$pluginname]))
				$instances[$pluginname] = new $pluginname(0);
		
		/* load id when it's not 0
		 * load 0 is handeled by load fn it's time for relaxation
		 */
		/*
		$instances[$pluginname] = $instances[$pluginname]->load($id);	
		return $instances[$pluginname];	
	}*/
	
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
	
	
	/*function will display listing of plugins */
	function renderRawData()
	{
		$pluginsInfo = $this->getAvailableInfo();
		if(!$pluginsInfo)
			return false;

		$html = "<select id = '$this->pluginType rawdata' name = '$this->pluginType rawdata' >";
		foreach($pluginsInfo as $k => $v){
			$html .= "<option value='$k'>".JText::_($v)."</option>"; 
		}
		
		$html .= "</select>";
		
		return $html;
	}
	
	
	public function getHtml(&$paramsHtml,&$plguinParamsHtml)
	{
		//Imp : Function will always call core field html
		$paramsHtml = $this->getParamsHtml();
		$plguinParamsHtml = $this->getPluginParamsHtml();
	}
	
	
	public function getPluginParamsHtml()
	{
		$plguinParamsHtml = $this->pluginParams->render('pluginparams');
		
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
	
	
	
	protected function generateSearchHtml($label='',$inputHtml='')
	{
		$html = array();
		if(empty($label))
			$label = $this->labelName;

		$html['label'] = $label;
			
		if(empty($inputHtml))
			$inputHtml = '<input type="text" name="'.$this->key.'" id="'.$this->key.'" />';
		
		$html['inputHtml'] = $inputHtml;
		
		return $html;
	}
	
	/*this function is defined for front-end
	 * return label + input box html
	 */
	public function renderSearchableHtml()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
			
		$view = $this->getViewName();
		if(false === $view)
			return $this->generateSearchHtml();
		
		if(false === $view->searchHtml($this))
			return $this->generateSearchHtml();
	}
	
	
	protected function getViewName()
	{
		/*We expect here that every plugin should have view 
		 * for display inteface .We will include view file
		 * and directly call function for displaying html
		 */
		$lowercase = strtolower($this->pluginType);
		
		$basePath = dirname(__CLASS__).DS.$lowercase;
		$viewPath = $basePath.DS.'views'.'view.html.php';
		
		if(!JFile::exists($viewPath))
			return false;
			
		require_once $viewPath;
		
		/*view class name = plugin class name with View*/
		$viewClass = $this->pluginType.'View';
		$view = new $viewClass();
		return $view;
	}
	

	public function renderSortableHtml()
	{
		$html = $this->labelName;
		return $html;
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

	
	/*get column name , returns a unique name for the given plugin*/
	protected function getCacheColumnName()
	{
		return $this->key;
	}
	
	
	/*fn return exact parameter details that will store
	 * in that field
	 */ 
	public function getCacheColumns()
	{
		$details[] = array();
		$details[0]['columnname'] = strtolower($this->pluginType).$this->getCacheColumnName();
		$details[0]['specs'] = 'varchar(250) NOT NULL';
		//$details[0]['default'] = '';
		return $details;
	}
	
	
	function getUserData(XiusQuery &$query)
	{
		$query->select('juser.`id` as userid');
		$query->from('`#__users` as juser');
	}
	
	
	function appendCreateQuery(XiusCreateTable &$createQuery)
	{
		$db = JFactory::getDBO();
		$columns = $this->getCacheColumns();
		
		if(empty($columns))
			return false;

		$columnDeatils = array();
		$i = 0;
		foreach($columns as $c){
			if(isset($c['columnname']) && !empty($c['columnname']))
				$columnDeatils[$i] .= $db->nameQuote($c['columnname']);
			else
				$columnDeatils[$i] .= $db->nameQuote(strtolower($this->pluginType).$this->getCacheColumnName());
		
			if(isset($c['specs']) && !empty($c['specs']))
				$columnDeatils[$i] .= ' '.$c['specs'];
			else
				$columnDeatils[$i] .= ' varchar(250) ';
				
			$i++;
		}
		
		$createQuery->appendColumns($columnDeatils);
		
	}
	
	
	/*function update query	 */
	public function addSearchToQuery(XiusQuery &$query,$value)
	{
		/*it's handling query only for single value
		 * if column needs multiple comparision then they should handle
		 */
		if(!is_array($value)) {
			$columns = $this->getCacheColumns();
			if(!$columns)
				return false;

			if(is_array($columns)) {
				foreach($columns as $c){
					$query->select($c['columnname']);
					$conditions =  $c['columnname']."='".$this->formatValue($value)."'";
					$query->where($conditions);
					return true;
				}
			}
			else{
				$query->select($columns['columnname']);
				$conditions =  $columns['columnname']."='".$this->formatValue($value)."'";
				$query->where($conditions);
				return true;
			}
			
			return false;
		}
		
		
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
}
