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
		
        foreach( $data as $user ){
        	$linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid={$user->id}&tmpl=component";
        	$buttonMap = XiusFactory::getModalButtonObject('xius_email_button',XiusText::_('EMAIL'),$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
        	$user->email	= '<a id="'.$buttonMap->modalname.$user->id.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'
        						.'<img src="'. JURI::base().'components/com_xius/assets/images/email.png" title="'.XiusText::_("XIUS EMAIL").'" /></a>&nbsp;';
            }
	}
	
	function onBeforeDisplayResultToolbar($toolbar)
	{
		$script = "function xiusCheckUserSelected(){
					var flag = false;
    				for (var i = 0; true; i++) {
			    		var str = 'xiusCheckUser' + i;
			    		var cbx = document.getElementById(str);
			    		if (!cbx) break;
			        	if(cbx.checked == true)
				           	flag = true;
				        } // for
    				var a = document.getElementById('xius_emailselected_button');
    				if(flag==false){	
    					a.href+='&selected=no';
    					return false;
    				}   
    				a.href+='&selected=yes';
    				return true;    			
    			}";
		
		$document =& JFactory::getDocument();        				
		$document->addScriptDeclaration($script);
		
        $linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid=selected&tmpl=component";
		$buttonMap = XiusFactory::getModalButtonObject('xius_emailselected_button','@',$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
		$obj= new stdClass();
        $obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'" onClick="return xiusCheckUserSelected()">'
        				.'<img src="'. JURI::base().'components/com_xius/assets/images/emailselected.png" title="'.XiusText::_("XIUS EMAIL TO SELECTED").'" /></a>&nbsp;';
   
		$toolbar['selected'] = $obj;
		
		// to send mail to all users
		$linkMap = "index.php?option=com_xius&task=emailUser&plugin=xiusemail&pluginid={$this->id}&userid=all&tmpl=component";
        $buttonMap = XiusFactory::getModalButtonObject('xius_emailall_button','@',$linkMap,XIUSEMAIL_IFRAME_WIDTH,XIUSEMAIL_IFRAME_HEIGHT);
        $obj= new stdClass();
        $obj->value = '<a id="'.$buttonMap->modalname.'" class="'.$buttonMap->modalname.'" title="'.$buttonMap->text.'" href="'.$buttonMap->link.'" rel="'.$buttonMap->options.'">'
        			  .'<img src="'. JURI::base().'components/com_xius/assets/images/emailall.png" title="'.XiusText::_("XIUS EMAIL ALL").'" /></a>&nbsp;';
   
		$toolbar['all'] = $obj;	
	}
}
