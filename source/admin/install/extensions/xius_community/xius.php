<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

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
		$incldePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($incldePath))
			return false;

		require_once $incldePath;
		$plgHandler = XiusFactory::getInstance('pluginhandler','lib');
		//echo " Running XIUS Cron update";
		return $plgHandler->onCronRun();
	}

	function onSystemStart()
	{
		require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';
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

		$toolbar->addItem('XIUS_SEARCH', 'XIUS_ADVANCEDSEARCH',XiusText::_('ADVANCEDSEARCH'), 'index.php?option=com_community&view=users&task=panel&usexius=1');
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

}

//XITODO : check existance of this file
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
		require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';
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
