<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';
require_once(dirname(__FILE__) . DS . 'defines.php');

class Xiusemail extends XiusBase
{

	function __construct()
	{
		$paramsxmlpath = dirname(__FILE__) . DS . 'params.xml';
		$ini	= dirname(__FILE__) . DS . 'params.ini';
		$data	= JFile::read($ini);
		
		if(JFile::exists($paramsxmlpath))
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		else{
			JError::raiseError(500,XiusText::_("INVALID XML PARAMETER FILE"));
			return false;
		}
		return (parent::__construct(__CLASS__));
	}
	
	function isAllRequirementSatisfy()
	{
//		$loggedInUser =& JFactory::getUser();
//		if(XiusHelpersUtils::isAdmin($loggedInUser->id)==false)
//			return false;
			
		return $this->isAccessible();	
	}
	
	public function isSortable()
	{
		return false;
	}
	
	public function getAvailableInfo()
	{	
		if(!$this->isAllRequirementSatisfy())
			return false;

		$pluginsInfo['Email'] = XiusText::_('EMAIL');
		
		
		return $pluginsInfo;
	}

	function getInfoName()
	{
		return XiusText::_('EMAIL');
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
			$this->pluginParams = new JParameter($data,$paramsxmlpath);
		
		if(!$this->pluginParams)
			$this->pluginParams	= new JParameter('','');	
	}
	
	function onBeforeDisplayProfileLink($data)
	{
		if(!$this->isAllRequirementSatisfy())
			return;
		
		$view = $this->getViewName();
        foreach( $data as $user ){
        	$user->email = $view->getIndividualEmailLink($this->id,$user->id);
        }
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		$view = $this->getViewName();
		$view->_setAdminToolbar($this->id);
	}
}
