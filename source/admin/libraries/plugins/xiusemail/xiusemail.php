<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

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
			JError::raiseError(500,JText::_("INVALID XML PARAMETER FILE"));
			return false;
		}
		parent::__construct(__CLASS__);
	}
	
	function isAllRequirementSatisfy()
	{
		$loggedInUser =& JFactory::getUser();
		if(XiusHelpersUtils::isAdmin($loggedInUser->id)==false)
			return false;
			
		return true;	
	}
	
	public function isSortable()
	{
		return false;
	}
	
	public function getAvailableInfo()
	{	
		if(!$this->isAllRequirementSatisfy())
			return false;

		$pluginsInfo['Email'] = JTEXT::_('EMAIL');
		
		
		return $pluginsInfo;
	}

	function getInfoName()
	{
		return JText::_('EMAIL');
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
		
        JHTML::_('behavior.modal', 'a.xius_email_button');
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', JText::_( '@' ));
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', 'xius_email_button');
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".XIUSEMAIL_IFRAME_WIDTH.", y: ".XIUSEMAIL_IFRAME_HEIGHT."}}");
        foreach( $data as $user ){
        	$linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid={$user->id}&tmpl=component";
        	$buttonMap->set('link', $linkMap);
        	$user->email	= '<a id="'.$buttonMap->modalname.$user->id.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'.$buttonMap->text.'</a>';
        }
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		JHTML::_('behavior.modal', 'a.xius_emailselected_button');
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', JText::_( '@' ));
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', 'xius_emailselected_button');
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".XIUSEMAIL_IFRAME_WIDTH.", y: ".XIUSEMAIL_IFRAME_HEIGHT."}}");
        $linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid=selected&tmpl=component";
        $buttonMap->set('link', $linkMap);
        $obj= new stdClass();
        $obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'
        				.'<img src="'. JURI::base().'components/com_xius/assets/images/emailselected.png" title="'.JText::_("EMAIL TO SELECTED").'" /></a>&nbsp;';
   
		$toolbar['selected'] = $obj;
		
		// to send mail to all users
		JHTML::_('behavior.modal', 'a.xius_emailall_button');
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', JText::_( 'All' ));
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', 'xius_emailall_button');
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".XIUSEMAIL_IFRAME_WIDTH.", y: ".XIUSEMAIL_IFRAME_HEIGHT."}}");
        $linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid=all&tmpl=component";
        $buttonMap->set('link', $linkMap);
        $obj= new stdClass();
        $obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'
        			  .'<img src="'. JURI::base().'components/com_xius/assets/images/emailall.png" title="'.JText::_("EMAIL ALL").'" /></a>';
   
		$toolbar['all'] = $obj;	
	}
	
}
