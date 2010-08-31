<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteControllerUsers extends XiusController
{
	
	function panel()
	{
		/*XITODO : Collect all info here
		 * ask admin , how many no's of info
		 * he want's to display at a time , and add more links.
		 * never assume anything
		 * show only searchable information
		 * for admin non-published info should be visible
		 */	
		$filter = array();
		$filter['published'] = true;
		
		$count = XiusHelpersUtils::getDisplayInformationCount();
		
		if($count === XIUS_ALL || $count === 0)
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		else
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',true,0,$count);
		
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$view->setLayout( 'default' );

		/*XITODO : pass only searchable information 
		 * Trigger event before displaying search 
		 */
		return $view->displaySearch($allInfo);
	}
	
	function search()
	{
		$scanned = JRequest::getVar('fromPanel', 0,'POST'); 
		if($scanned){			
			$conditions = XiusLibrariesUsersearch::processSearchData();
			XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		
			$join = JRequest::getVar('xius_join','AND','POST');
			XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		}
		return $this->_displayResult(__FUNCTION__);
	}
		
	function join()
	{
		$join = JRequest::getVar('xiusjoin','AND','POST');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		return $this->_displayResult('search');
	}
	
	function addinfo()
	{
		XiusLibrariesUsersearch::addSearchData();
		return $this->_displayResult('search');
	}
	
	function delinfo()
	{
		XiusLibrariesUsersearch::deleteSearchData();
		return $this->_displayResult('search');
	}
	
	function sort()
	{
		XiusLibrariesUsersearch::processSortData();
		return $this->_displayResult('search');
	}

	function sortdir()
	{
		XiusLibrariesUsersearch::processSortData();
		return $this->_displayResult('search');
	}
	
	function resetfilter()
	{
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,'','XIUS');
		$join = JRequest::getVar('xius_join','AND','POST');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		return $this->_displayResult('search');
	}	
	
	function _displayResult($fromTask,$list='')
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		$view->setLayout( 'results' );
		return $view->displayResult($fromTask,$list);
	}
	

	function export($fromTask='search')
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$viewType	= 'csv';
		$view		=& $this->getView( $viewName , $viewType );
		return $view->exportUser($fromTask);
	}	
	
	
	function displayAdvanceSearch()
	{
		$viewName	= JRequest::getCmd( 'view' , 'users' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );		
		$view->setLayout( 'advance_search' );
		return $view->displayAdvanceSearch();	
	}

	function runCron()
	{
		if(XiusHelpersUtils::verifyCronRunRequired() == false)
			return;
			
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_START_TIME,$time);
		
		XiusLibrariesUsersearch::updateCache();
		
		$time = XiusLibrariesUsersearch::getTimestamp();
		XiusLibrariesUsersearch::saveCacheParams(XIUS_CACHE_END_TIME,$time);
		
		return;
	}
	
	function _runCron($limit)
	{
		$cache = XiusFactory::getCacheObject();
		if($limit['limitStart'] == 0) {
			if(!$cache->createTable(true))
				return false;
		}
		$getDataQuery = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		return $cache->insertIntoTable($getDataQuery,true,$limit);		
	}
	
}
