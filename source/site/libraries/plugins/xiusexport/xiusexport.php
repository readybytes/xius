<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class Xiusexport extends XiusBase
{

function __construct()
	{
	/*	$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new XiusParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,XiusText::_("INVALID XML PARAMETER FILE"));
			return false;
		}*/
		return parent::__construct(__CLASS__);
	}
	
	
function isAllRequirementSatisfy()
	{
		return $this->isAccessible();	
	}

public function getAvailableInfo()
	{
		if(!$this->isAllRequirementSatisfy())
			return false;
		$pluginsInfo['xius_export'] = 'export';
		return $pluginsInfo;
	}
	
function getInfoName()
	{
		return XiusText::_('EXPORT');
	}
	
	/* 
	 * Export Info is not sortable 
	 */
public function isSortable()
	{
		return false;
	}
	
public function addSearchToQuery(XiusQuery &$query,$value,$operator='=',$join='AND')
	{
		return true;
	}
	
	/*function will provide query for getting user info from
	 * tables. eq :- get info from #__users table 
	 */
function getUserData(XiusQuery &$query)
	{
		return true;
	}

public function cleanPluginObject()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new XiusParameter($data,$paramsxmlpath);
		
		if(!$this->pluginParams)
			$this->pluginParams	= new XiusParameter('','');	
	}
	
function onBeforeDisplayResultToolbar($toolbar)
	{
		$view = $this->getViewName();
		$view->_setAdminToolbar($this->id);
	}
	
	function isExportable()
	{
		return false;
	}
}