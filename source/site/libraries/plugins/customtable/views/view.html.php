<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'joomla'.DS.'joomlahelper.php';

class CustomtableView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function rawDataHtml(XiusBase $calleObject)
	{
		$this->setLayout('rawdata');
		$info = $calleObject->getAvailableInfo();
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}

	/*
     * @since Xius-4.1	
	 * for multiple value, the by default customtable is only text box type,
	 * so it need to be overided in case of multiple usergroup
	 */
	function searchHtml($calleObject,$value='')
	{
		$this->setLayout('search');
		$this->assign('calleObject' , $calleObject);
		$this->assign('value' , $value);
		$this->assign('key' , $calleObject->get('key'));
		
		ob_start();
		$this->display();
	
		$contents = ob_get_clean();
		return $contents;
	}
}

