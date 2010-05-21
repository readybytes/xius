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

	function plgCommunityxius( &$subject, $params )
	{
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
}
