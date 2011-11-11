<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;
require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';

class plgCommunityxius extends JPlugin
{
	var $name 		= "Show JomSocial User Lists";
	var $_name		= 'xius';
	var $_path		= '';
	var $_user		= '';
	var $_my		= '';
	var $_params;

	function plgCommunityxius( &$subject, $params )
	{
		$plugin =& JPluginHelper::getPlugin('community', 'xius');
 		$this->params = new JParameter($plugin->params);
		parent::__construct( $subject, $params );

	}

	function onCronRun()
	{
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		//echo " Running XIUS Cron update";
		return $plgHandler->onCronRun();
	}

	function onSystemStart()
	{
		$showSearchMenuTab=XiusHelperUtils::getConfigurationParams('integrateJomSocial',0);
		//$this->params->get('showSearchMenuTab', 0);

			if(!$showSearchMenuTab){
				return;
			}

		$lang =& JFactory::getLanguage();
		$user		= CFactory::getUser();
		$lang->load('com_xius', JPATH_SITE);

		$toolbar  = CFactory::getToolbar();
		$toolbar->addGroup('XIUS_SEARCH', XiusText::_('SEARCH'),
							 'index.php?option=com_community&view=users&task=search&usexius=1');

		$toolbar->addItem('XIUS_SEARCH', 'XIUS_ADVANCEDSEARCH',XiusText::_('ADVANCEDSEARCH'), 'index.php?option=com_community&view=users&usexius=1');
		$toolbar->addItem('XIUS_SEARCH', 'XIUS_USERLIST', XiusText::_('USERLIST'), 'index.php?option=com_community&view=list&task=lists&usexius=1');
//		$toolbar->removeItem(TOOLBAR_FRIEND, 'FRIEND_SEARCH_FRIENDS');
//		$toolbar->removeItem(TOOLBAR_FRIEND, 'FRIEND_ADVANCE_SEARCH_FRIENDS');
		// remove toolbar item(Search and advance search)
		XiusLibPluginhandler::setJSToolbarState();

	}


//	function onAppDisplay()
//	{
//		if(!$this->include_files())
//			return 'User list component does not exits. Please verify !!!';
//
//		require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';
//
//		$xiusview = JRequest::getCmd('xiusview','users');
//		$xiustask = JRequest::getCmd('xiustask','panel');
//		$view = 'XiussiteController'.JString::ucfirst($xiusview);
//
//		$obj = new $view(true);
//
//		$obj->getView()->_isExternalUrl= true;
//		$content = $obj->execute($xiustask);
//		return $content;
//	}

	function onBeforeControllerCreate(&$controller)
	{
		$isXius  = JRequest::getVar('usexius','0');

		if($isXius ==='1')
			$controller = 'CommunityXiusController';

		return true;
	}

	/**
	 * JS_field_value table will be updated.
	 * @param unknown_type $userId
	 * @param unknown_type $saveSuccess
	 */
	function onAfterProfileUpdate($userId, $saveSuccess)
	{
		if(empty($saveSuccess)){
			return true;
		}
		
		$db 	= JFactory::getDbo();
		$query 	= "SHOW TABLES LIKE '".$db->getPrefix()."xius_jsfields_value'";
		$db->setQuery($query);
		$tableExist = $db->loadResult(); 
		//Check table exist or not
		if(empty($tableExist)){
			return true;
		}
		
		//get All Jsfields information
		//XiTODO:: Might be effected by Privacy. Please Properly test  it.
		$filter['pluginType'] = "'Jsfields'";	
		$jsInfo = XiusFactory::getInstance ( 'info', 'model' )->getAllInfo($filter,'AND',false);		
		

		/* 
		 * get jsfields value from community_field_value table 
		 * update xius_jsfield_value table
		 */
		$query	  = "SELECT `user_id`";
		foreach($jsInfo as $info){
			$column  = "field_id_{$info->key}";
			$query 	.= ", GROUP_CONCAT( DISTINCT (if(`field_id`= {$info->key}, `value`, NULL))) AS $column";
		}

		$query .= " FROM `#__community_fields_values`".
				  " WHERE `user_id`= $userId ";
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$insertQuery = "INSERT INTO `#__xius_jsfields_value` (`user_id`";
		$insertValue = " VALUES( $userId ";
		$onUpdate	 = " ON DUPLICATE KEY UPDATE ";
		
		foreach($jsInfo as $info){
			$column    		 = "field_id_{$info->key}";
			$insertQuery	.= ", `$column`";
			if(is_numeric($result[0]->$column)){
				$insertValue	.= ", {$result[0]->$column} ";
				$onUpdate 		.= ", `$column` = {$result[0]->$column} ";
				continue;
			}
			$insertValue	.= ", '{$result[0]->$column}' ";
			$onUpdate 		.= ", `$column` = '{$result[0]->$column}' ";
		}
		$onUpdate = preg_replace('/,/', '',$onUpdate, 1);
		$query    = $insertQuery.")".$insertValue.")".$onUpdate;
		$db->setQuery($query);
		if(!$db->query()){
			JFactory::getApplication()->enqueueMessage("XiUS JSfield value doesn't update. Please say to your site administrator");	
		}
	return true;
		
	}

}

if(!JFile::exists(JPATH_ROOT .DS.'components'.DS.'com_community'.DS.'controllers'.DS.'controller.php')){
	JFactory::getApplication()->enqueueMessage("Jom-social does not exist");
	return;
}
require_once COMMUNITY_COM_PATH.DS.'controllers'.DS.'controller.php';

class CommunityXiusController extends CommunityBaseController
{
	var $_methods = array();
	function execute($task='')
	{
		//add default values
		$this->xiusOrigTask = $task === '' ? 'panel' : $task;
		$this->xiusOrigView = JRequest::getVar('view','users');
		$this->xiusOrigFormat = JRequest::getVar('format','html');
	
		//need to hack it, as JomSocial is preety STUPID at few task
		if(JRequest::getVar('tmpl',null)===null
				&& $this->xiusOrigFormat === 'html' )
		{
			JRequest::setVar('view','search');
			return	parent::execute('doTask');
		}
			
		return $this->doTask();
	}

	function doTask()
	{
		$controllerClass = 'XiussiteController'.JString::ucfirst($this->xiusOrigView);
		$controller = new $controllerClass(true);

		echo $controller->execute($this->xiusOrigTask);
		//set original view, so JS can pick correct active menu
		JRequest::setVar('view',$this->xiusOrigView);
	}
	
	function getView($viewName ='frontpage', $prefix = '', $viewType = '')
	{	
		//just before view
		$view =  parent::getView('search', $prefix, $viewType);
		$view->setTitle(" ");
		return $view;
	}
}
