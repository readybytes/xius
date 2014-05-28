<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusViewConfiguration extends XiusView 
{
	protected $_name = 'configuration';

	function display($tpl = null)
	{
		$cModel = XiusFactory::getInstance ('configuration','model');
		$params	= $cModel->getParams();
		$this->assign( 'params' , $params );
		parent::display( $tpl );
    }
	
	
	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/	 	 
	function setToolBar()
	{
		// Add the necessary buttons
		JToolBarHelper::save('save','COM_XIUS_SAVE');		 
		JToolBarHelper::custom("runCron",'refresh','','COM_XIUS_UPDATE_CACHE',0,0); 			
		//JToolBarHelper::custom('reset','reset','','RESET',0,0); 
	}
}
