<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'jsfieldshelper.php';

class JsfieldsView extends XiusBaseView 
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
		$filter = array();
		$filter['id'] = $calleObject->get('key');
		$field = jsfieldshelper::getJomsocialFields($filter);
		if(!$field) 		
			return false;	

		//Id is unique , so we will get single field of jomsocial always
		$field[0]->value = $value;
			
		$fieldHtml = jsfieldshelper::getFieldsHTML($field[0]);
		$this->assign('fieldHtml',$fieldHtml);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		
		return $contents;
	}
	
}
