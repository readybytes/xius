<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
 
class XiusControllerCpanel extends XiusAdminController 
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
	
//	function updateCache()
//	{
//		global $mainframe;
//		
//		$limitStart=JRequest::getVar('limitStart', 0, 'GET');
//		
//		$cache = XiusFactory::getCacheObject();
//		if($limitStart == 0) {
//			if(!$cache->createTable(true))
//				return false;
//		}
//
//		$getDataQuery = XiusLibrariesUsersearch::buildInsertUserdataQuery();
//		
//		$limit = array();
//		$limit['limitStart'] = $limitStart;
//		$limit['limit'] = XiusHelpersUtils::getUserLimit();
//		
//		$insertedRows = $cache->insertIntoTable($getDataQuery,true,$limit);
//		
//		if($insertedRows == $limit['limit']){
//			$limitStart += $limit['limit'];
//    		$mainframe->redirect(XiusRoute::_("index.php?option=com_xius&view=cpanel&task=updateCache&limitStart=".$limitStart,false));
//		}
//		
//		$msg = XiusText::_('CACHE UPDATED SUCCESSFULLY');
//		$url = XiusRoute::_("index.php?option=com_xius&view=cpanel",false);
//		$mainframe->redirect($url,$msg,false);
//		return true;
//	}
		
}
