<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
 
class XiusControllerCpanel extends JController 
{
    
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	
    function display() 
	{
		parent::display();
    }
    

    function updates()
	{
		$viewName	= JRequest::getCmd( 'view' , 'cpanel' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'mainupdates' );
		$view->setLayout( $layout );
		
		echo $view->updates();
	}
	
	function updateCache()
	{
		global $mainframe;
		
		$limitStart=JRequest::getVar('limitStart', 0, 'GET');
		
		$cache = XiusFactory::getCacheObject();
		if($limitStart == 0) {
			if(!$cache->createTable(true))
				return false;
		}

		$getDataQuery = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		
		$limit = array();
		$limit['limitStart'] = $limitStart;
		$limit['limit'] = XiusHelpersUtils::getUserLimit();
		
		$insertedRows = $cache->insertIntoTable($getDataQuery,true,$limit);
		
		if($insertedRows == $limit['limit']){
			$limitStart += $limit['limit'];
    		$mainframe->redirect(JRoute::_("index.php?option=com_xius&view=cpanel&task=updateCache&limitStart=".$limitStart,false));
		}
		
		$msg = JText::_('CACHE UPDATED SUCCESSFULLY');
		$url = JRoute::_("index.php?option=com_xius&view=cpanel",false);
		$mainframe->redirect($url,$msg,false);
	}
		
}
