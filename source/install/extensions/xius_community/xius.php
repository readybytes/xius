<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgCommunityxius extends JPlugin
{
	var $_debugMode = 0;
	var $parmas;
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
		$plgHandler = XiusFactory::getLibraryPluginHandler();
		echo " Running XIUS Cron update";
		return $plgHandler->onCronRun();
	}
	
	function onSystemStart()
	{
		require_once JPATH_ROOT.DS. 'components'.DS.'com_xius'.DS.'includes.php';
		$showSearchMenuTab=XiusHelpersUtils::getConfigurationParams('showSearchMenuTab',0);
		//$this->params->get('showSearchMenuTab', 0);
	
			if(!$showSearchMenuTab){
				return;
			}
			
		$lang =& JFactory::getLanguage();
		$lang->load('com_xius', JPATH_SITE);
		
		$toolbar	=& CFactory::getToolbar();		
		$toolbar->addGroup('XIUS_SEARCH', JText::_('SEARCH'),
							JRoute::_('index.php?option=com_xius'));
		$toolbar->addItem('XIUS_SEARCH', 'XIUS_ADVANCEDSEARCH', JText::_('ADVANCEDSEARCH'), JRoute::_('index.php?option=com_xius'));
		$toolbar->addItem('XIUS_SEARCH', 'XIUS_USERLIST', JText::_('USERLIST'), JRoute::_('index.php?option=com_xius&view=users&layout=lists&task=displayList'));
		$toolbar->removeItem(TOOLBAR_FRIEND, 'FRIEND_SEARCH_FRIENDS');
		$toolbar->removeItem(TOOLBAR_FRIEND, 'FRIEND_ADVANCE_SEARCH_FRIENDS');
	}
	
}
