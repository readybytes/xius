<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'joomla'.DS.'joomlahelper.php';

class JsuserView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$this->setLayout('search');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */	
			
		$fieldHtml = Jsuserhelper::getFieldsHTML($calleObject,$value);
		
		if(false == $fieldHtml)
			$fieldHtml = parent::searchHtml($calleObject,$value);
		
		$this->assign('fieldHtml',$fieldHtml);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}
	
}
