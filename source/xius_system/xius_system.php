<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgSystemxius_system extends JPlugin
{
	var $_debugMode = 0;
		
	function plgSystemxius_system( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	
	
	function onUsInfoUpdated($data)
	{
		$incldePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($incldePath))
			return;

		require_once $incldePath;
		$plgHandler = XiusFactory::getLibraryPluginHandler();
		return $plgHandler->onUsInfoUpdated($data);
	}
}