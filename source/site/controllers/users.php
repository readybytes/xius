<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiussiteControllerUsers extends XiusController
{	
	function __construct($config=array())
	{
		parent::__construct($config);
	}
	
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
		
		$count = XIUS_ALL; 
		
		if($count === XIUS_ALL || $count === 0)
			$allInfo = XiusLibInfo::getInfo($filter,'AND',false);
		else
			$allInfo = XiusLibInfo::getInfo($filter,'AND',true,0,$count);
		
		$view		=& $this->getView();
		
		/*
		 * IMP : Set the URL where the Form must be submitted
		 * so that URL can be set from external site
		 */	
		// set and reset the vars in current url
		$view->setXiUrl(array('view'=>$this->getName(),'task'=>'search',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));
		/*XITODO : pass only searchable information 
		 * Trigger event before displaying search 
		 */
		return $view->panel($allInfo);
	}
	
	function search()
	{
		$fromPanel = JRequest::getVar('fromPanel', 0,'POST');
		$defaultSelect = XiusHelperUtils::getConfigurationParams('xiusSortInfo',0);
		XiusLibUsersearch::setDataInSession(XIUS_SORT,$defaultSelect,'XIUS');
			
		$order = XiusHelperUtils::getConfigurationParams('xiusSortOrder','ASC');
		XiusLibUsersearch::setDataInSession(XIUS_DIR,$order,'XIUS'); 
		if($fromPanel){			
			$conditions = XiusLibUsersearch::processSearchData();
			XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		
			$join = JRequest::getVar('xiusjoin','AND','POST');
			XiusLibUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');		
		}
		return $this->_displayResult(__FUNCTION__);
	}
		
	function join()
	{
		$join = JRequest::getVar('xiusjoin','AND','POST');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		return $this->_displayResult('search');
	}
	
	function addinfo()
	{
		XiusLibUsersearch::addSearchData();
		return $this->_displayResult('search');
	}
	
	function delinfo()
	{
		XiusLibUsersearch::deleteSearchData();
		return $this->_displayResult('search');
	}
	
	function sort()
	{
		XiusLibUsersearch::processSortData();
		return $this->_displayResult('search');
	}

	function sortdir()
	{
		XiusLibUsersearch::processSortData();
		return $this->_displayResult('search');
	}
	
	function resetfilter()
	{
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,'','XIUS');
		$join = JRequest::getVar('xius_join','AND','POST');
		XiusLibUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		return $this->_displayResult('search');
	}	
	
	function _displayResult($fromTask,$list='')
	{
		$view		=& $this->getView();
		
		if(count(XiusLibInfo::getInfo()) == 0)
			  return $view->panel('');	
		
			// set and reset the vars in current url
		$view->setXiUrl(array('view'=>$this->getName(),'task'=>'search',
							'tmpl'=>null,'listid'=>null,'isnew'=>null));		
		return $view->displayResult($fromTask,$list,'result');
	}
	
	function export()
	{
		$viewType	= 'csv';
		$view		=& $this->getView();
		$layout		= JRequest::getCmd( 'layout' , 'default' );
		$view->setLayout( $layout );
		return $view->export();
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
		if(XiusHelperUtils::verifyCronRunRequired() == false){
			return;
		}
			
		if(!XiusLibCron::autoCronJob()){
			return;
		}
		
		$time = XiusLibCron::getTimestamp();
		XiusLibCron::saveCacheParams(XIUS_CACHE_START_TIME,$time);
		
		XiusLibCron::updateCache();
		
		$time = XiusLibCron::getTimestamp();
		XiusLibCron::saveCacheParams(XIUS_CACHE_END_TIME,$time);
		
		return; 
	}

	// only testing purpose
	function _runCron($limit)
	{
		$cache = XiusFactory::getInstance('cache');
		if($limit['limitStart'] == 0) {
			if(!$cache->createTable())
				return false;
		}
		$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
		return $cache->insertIntoTable($getDataQuery,true,$limit);		
	}
	
}
